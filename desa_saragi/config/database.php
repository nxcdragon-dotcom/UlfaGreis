<?php
/**
 * Database Configuration and Connection Class
 * Using PDO for secure database operations
 */

class Database {
    // Database configuration
    private const HOST = 'localhost';
    private const DB_NAME = 'desa_saragi';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';
    private const DB_PORT = 3306;
    private const CHARSET = 'utf8mb4';
    
    // Static property to hold the connection instance (singleton pattern)
    private static $connection = null;
    
    /**
     * Get database connection
     * @return PDO Database connection object
     */
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=' . self::HOST 
                    . ';port=' . self::DB_PORT 
                    . ';dbname=' . self::DB_NAME 
                    . ';charset=' . self::CHARSET;
                
                self::$connection = new PDO(
                    $dsn,
                    self::DB_USER,
                    self::DB_PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die('Database Connection Error: ' . $e->getMessage());
            }
        }
        
        return self::$connection;
    }
    
    /**
     * Execute a prepared query
     * @param string $query SQL query with placeholders
     * @param array $params Parameters to bind
     * @return PDOStatement Prepared statement
     */
    public static function prepare($query) {
        return self::getConnection()->prepare($query);
    }
    
    /**
     * Execute a query and return results
     * @param string $query SQL query
     * @param array $params Parameters to bind
     * @return array Array of results
     */
    public static function fetch($query, $params = []) {
        $stmt = self::prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Execute a query and return single row
     * @param string $query SQL query
     * @param array $params Parameters to bind
     * @return array Single row result
     */
    public static function fetchOne($query, $params = []) {
        $stmt = self::prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    /**
     * Execute INSERT, UPDATE, DELETE queries
     * @param string $query SQL query
     * @param array $params Parameters to bind
     * @return int Number of affected rows
     */
    public static function execute($query, $params = []) {
        $stmt = self::prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
    
    /**
     * Get last inserted ID
     * @return string Last insert ID
     */
    public static function lastInsertId() {
        return self::getConnection()->lastInsertId();
    }
}
?>
