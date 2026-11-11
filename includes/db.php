<?php
/**
 * Lapisan database (PDO). Mendukung MySQL/MariaDB (produksi) dan SQLite (uji lokal).
 */
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $driver = config('db.driver', 'mysql');
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        if ($driver === 'sqlite') {
            $path = ROOT_DIR . '/' . ltrim((string) config('db.sqlite_path', 'storage/database.sqlite'), '/');
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0775, true);
            }
            $pdo = new PDO('sqlite:' . $path, null, null, $options);
            $pdo->exec('PRAGMA foreign_keys = ON');
        } else {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                config('db.host', 'localhost'),
                (int) config('db.port', 3306),
                config('db.name'),
                config('db.charset', 'utf8mb4')
            );
            $pdo = new PDO($dsn, (string) config('db.user'), (string) config('db.pass'), $options);
        }
    } catch (PDOException $e) {
        if (defined('INSTALLER')) {
            throw $e;
        }
        http_response_code(500);
        $msg = config('debug') ? htmlspecialchars($e->getMessage()) : 'Periksa pengaturan database di config.php.';
        exit('<!doctype html><meta charset="utf-8"><title>Database error</title>'
            . '<div style="font-family:sans-serif;max-width:560px;margin:80px auto"><h1>Gagal terhubung ke database</h1><p>'
            . $msg . '</p></div>');
    }

    return $pdo;
}

function db_driver(): string
{
    return config('db.driver', 'mysql') === 'sqlite' ? 'sqlite' : 'mysql';
}

/** Membuat seluruh tabel bila belum ada. */
function db_create_tables(): void
{
    $sqlite = db_driver() === 'sqlite';
    $pk     = $sqlite ? 'INTEGER PRIMARY KEY AUTOINCREMENT' : 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';
    $text   = $sqlite ? 'TEXT' : 'MEDIUMTEXT';
    $engine = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

    $statements = [
        "CREATE TABLE IF NOT EXISTS users (
            id $pk,
            username VARCHAR(60) NOT NULL UNIQUE,
            name VARCHAR(120) NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL DEFAULT 'editor',
            last_login DATETIME NULL,
            created_at DATETIME NOT NULL
        )$engine",
        "CREATE TABLE IF NOT EXISTS settings (
            skey VARCHAR(120) NOT NULL PRIMARY KEY,
            svalue $text NULL,
            updated_at DATETIME NOT NULL
        )$engine",
        "CREATE TABLE IF NOT EXISTS items (
            id $pk,
            collection VARCHAR(60) NOT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            is_active TINYINT NOT NULL DEFAULT 1,
            data $text NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )$engine",
        "CREATE TABLE IF NOT EXISTS login_attempts (
            id $pk,
            ip VARCHAR(64) NOT NULL,
            attempted_at DATETIME NOT NULL
        )$engine",
    ];

    foreach ($statements as $sql) {
        db()->exec($sql);
    }

    // Index (diabaikan bila sudah ada).
    $indexes = [
        'CREATE INDEX idx_items_collection ON items (collection, sort_order)',
        'CREATE INDEX idx_login_ip ON login_attempts (ip, attempted_at)',
    ];
    foreach ($indexes as $sql) {
        try {
            db()->exec($sql);
        } catch (PDOException $e) {
            // index sudah ada
        }
    }
}

function now(): string
{
    return date('Y-m-d H:i:s');
}

/* ------------------------------------------------------------------ */
/* Settings (konten halaman & identitas sekolah)                       */
/* ------------------------------------------------------------------ */

function settings_all(): array
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        try {
            foreach (db()->query('SELECT skey, svalue FROM settings') as $row) {
                $cache[$row['skey']] = $row['svalue'];
            }
        } catch (PDOException $e) {
            $cache = [];
        }
    }
    return $cache;
}

function settings_save(array $values): void
{
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $del = $pdo->prepare('DELETE FROM settings WHERE skey = ?');
        $ins = $pdo->prepare('INSERT INTO settings (skey, svalue, updated_at) VALUES (?, ?, ?)');
        foreach ($values as $key => $value) {
            $del->execute([$key]);
            $ins->execute([$key, $value, now()]);
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/* ------------------------------------------------------------------ */
/* Items (daftar/koleksi: guru, prestasi, fasilitas, dll.)              */
/* ------------------------------------------------------------------ */

function items_decode(array $row): array
{
    $data = json_decode((string) $row['data'], true) ?: [];
    $data['_id']     = (int) $row['id'];
    $data['_active'] = (int) $row['is_active'] === 1;
    $data['_sort']   = (int) $row['sort_order'];
    return $data;
}

/** Mengambil item satu koleksi, terurut. */
function items(string $collection, bool $onlyActive = true): array
{
    static $cache = [];
    $cacheKey = $collection . ($onlyActive ? ':a' : ':all');
    if (isset($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }
    $sql = 'SELECT * FROM items WHERE collection = ?' . ($onlyActive ? ' AND is_active = 1' : '') . ' ORDER BY sort_order ASC, id ASC';
    try {
        $stmt = db()->prepare($sql);
        $stmt->execute([$collection]);
        $rows = array_map('items_decode', $stmt->fetchAll());
    } catch (PDOException $e) {
        $rows = [];
    }
    return $cache[$cacheKey] = $rows;
}

function item_find(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM items WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        return null;
    }
    $item = items_decode($row);
    $item['_collection'] = $row['collection'];
    return $item;
}

function item_create(string $collection, array $data, bool $active = true): int
{
    $stmt = db()->prepare('SELECT COALESCE(MAX(sort_order), 0) FROM items WHERE collection = ?');
    $stmt->execute([$collection]);
    $sort = (int) $stmt->fetchColumn() + 10;

    $stmt = db()->prepare('INSERT INTO items (collection, sort_order, is_active, data, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$collection, $sort, $active ? 1 : 0, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), now(), now()]);
    return (int) db()->lastInsertId();
}

function item_update(int $id, array $data, bool $active): void
{
    $stmt = db()->prepare('UPDATE items SET data = ?, is_active = ?, updated_at = ? WHERE id = ?');
    $stmt->execute([json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $active ? 1 : 0, now(), $id]);
}

function item_set_active(int $id, bool $active): void
{
    $stmt = db()->prepare('UPDATE items SET is_active = ?, updated_at = ? WHERE id = ?');
    $stmt->execute([$active ? 1 : 0, now(), $id]);
}

function item_delete(int $id): void
{
    $stmt = db()->prepare('DELETE FROM items WHERE id = ?');
    $stmt->execute([$id]);
}

/** Menukar urutan item dengan tetangganya (arah: -1 naik, +1 turun). */
function item_move(int $id, int $direction): void
{
    $item = item_find($id);
    if (!$item) {
        return;
    }
    $list = items($item['_collection'], false);
    $ids = array_column($list, '_id');
    $pos = array_search($id, $ids, true);
    $target = $pos + $direction;
    if ($pos === false || $target < 0 || $target >= count($ids)) {
        return;
    }
    [$ids[$pos], $ids[$target]] = [$ids[$target], $ids[$pos]];
    $stmt = db()->prepare('UPDATE items SET sort_order = ? WHERE id = ?');
    foreach ($ids as $i => $itemId) {
        $stmt->execute([($i + 1) * 10, $itemId]);
    }
}

function items_count(string $collection): int
{
    $stmt = db()->prepare('SELECT COUNT(*) FROM items WHERE collection = ?');
    $stmt->execute([$collection]);
    return (int) $stmt->fetchColumn();
}

