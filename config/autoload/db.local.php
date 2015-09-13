return array(
  'db' => array(
    'driver'         => 'Pdo',
    'dsn'            => 'mysql:dbname=trinec;host=localhost',
    'username'       =>'root',
    'password'       => '',
    'driver_options' => array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    ),
  ),
  'service_manager' => array(
    'aliases' => array(
      'db' => 'Zend\Db\Adapter\Adapter',
    ),
  ),
);
