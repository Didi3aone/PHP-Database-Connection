<?php
// database connection
// default is mysql, just change ['db_DB'] in the config file if you want

class Database
{
	protected 	$config,
				$conn,
				$q,
				$bindings,
				$config_path = '';

	public function __construct ($path = '')
	{

		$keys = ['db_DB', 'db_host', 'db_user', 'db_password', 'db_name'];

		$this->config_path = ($path) ? $path . 'config.php' : 'config.php';

		if (!file_exists($this->config_path) ){
			die("Error establishing database");
		}
		$this->config = include $this->config_path;

		foreach ($keys as $index => $value) {
			if (!array_key_exists($value, $this->config)) {
				die("Error establishing database");
			}
		}

		$this->set_connection ();
	}

	private function set_connection ()
	{
		try {
			$this->conn =  new PDO($this->config['db_DB']. ':host=' . $this->config['db_host'] . ';dbname=' . $this->config['db_name'] . ';' , $this->config['db_user'], $this->config['db_password']);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	private function set_query ($q, $bindings) {
		$this->q = $q;
		$this->bindings = $bindings;
		return (empty($this->q)) ? 0 : 1;
	}

	private function perform_query ()
	{
		try {
			$stmt = $this->conn->prepare($this->q);
			$stmt->execute($this->bindings);
			return $stmt->fetchALL(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function query ($q = '', $bindings = [])
	{
		return (!$this->set_query($q, $bindings)) ? "Invalid query" : $this->perform_query();
	}


}
