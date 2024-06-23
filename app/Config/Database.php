<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     */
    public string $defaultGroup = 'main';

    /**
     * The default database connection.
     */
    public $main;
    public $replica;

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     */
    public array $tests = [
        'DSN' => '',
        'hostname' => '127.0.0.1',
        'username' => '',
        'password' => '',
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect' => false,
        'DBDebug' => true,
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }

        switch ($_SERVER['ENV']) {
            case 'prd':
            case 'stg': // PRD 디비
                // main
                $mainHostname = MAIN_DATABASE_IP;
                $mainUsername = MAIN_DATABASE_USERNAME;
                $mainPassword = MAIN_DATABASE_PASSWORD;
                $mainDatabase = MAIN_DATABASE_DATABASE;
                // replica
                $replicaHostname = REPLICA_DATABASE_IP;
                $replicaUsername = REPLICA_DATABASE_USERNAME;
                $replicaPassword = REPLICA_DATABASE_PASSWORD;
                $replicaDatabase = REPLICA_DATABASE_DATABASE;
                break;

            case 'dev': // 개발디비
                // main
                $mainHostname = DEV_DATABASE_IP;
                $mainUsername = DEV_DATABASE_USERNAME;
                $mainPassword = DEV_DATABASE_PASSWORD;
                $mainDatabase = DEV_DATABASE_DATABASE;
                // replica
                $replicaHostname = DEV_REPLICA_DATABASE_IP;
                $replicaUsername = DEV_REPLICA_DATABASE_USERNAME;
                $replicaPassword = DEV_REPLICA_DATABASE_PASSWORD;
                $replicaDatabase = DEV_REPLICA_DATABASE_DATABASE;
                break;

            case 'docker':
            default:
                // main
                $mainHostname = "mysql";
                $mainUsername = "root";
                $mainPassword = "1234";
                $mainDatabase = "test";
                // replica
                $replicaHostname = "mysql";
                $replicaUsername = "root";
                $replicaPassword = "1234";
                $replicaDatabase = "test";
        }

        $this->main = [
            'DSN' => '',
            'hostname' => $mainHostname,
            'username' => $mainUsername,
            'password' => $mainPassword,
            'database' => $mainDatabase,
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug' => (ENVIRONMENT !== 'production'),
            'charset' => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre' => '',
            'encrypt' => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port' => 3306
        ];

        $this->replica = [
            'DSN' => '',
            'hostname' => $replicaHostname,
            'username' => $replicaUsername,
            'password' => $replicaPassword,
            'database' => $replicaDatabase,
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug' => (ENVIRONMENT !== 'production'),
            'charset' => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre' => '',
            'encrypt' => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port' => 3306,
        ];
    }
}
