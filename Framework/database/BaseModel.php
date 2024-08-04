<?php 
namespace Framework\database;
use table;
use PDO;
class BaseModel {
	
	protected $table;
	protected $id;
	protected $fillable;

	private   $prefix;

	public $timestamps = true;

	private $save = [];

	function __construct() {
		$this->prefix = config('prefix', 'db');

		if (!$this->table) {
			$this->table = strtolower(basename(get_called_class()));
		}

		$this->table = explode('\\', $this->table);
		$this->table = end($this->table);
		$this->table = $this->prefix.$this->table;

	}

	function __set($k, $v){
		$this->save[$k] = $v;
	}

	public function find($id){
		$q = new table($this->table);
		$q->select($this->fillable);
		return $q->where([$this->id => $id]);
	}

	public function join($data){
		$q = new table($this->table);
		return $q->select($this->fillable)->join($data);
	}

	public function save(){
		$q = (new table($this->table))->insert($this->save);
		return $q;
	}

	public function create($values){
		$q = (new table($this->table))->insert($values);
		return $q;
	}

	public function MultiInsert($values){
		$q = (new table($this->table))->MultiInsert($values);
		return $q;
	}

	public function where(array $w)	{
		$q = new table($this->table);
		$q->select($this->fillable);
		return $q->where($w);
	}

	public function select($s)	{
		$q = new table($this->table);		
		return $q->select($s);
	}

	public function get()	{
		$q = new table($this->table);		
		return $q->select($this->fillable)->get();
	}

	public function count()	{
		return (new table($this->table))->select($this->id)->count();
	}

	public function search(array $search) {
		$fillable = implode(', ', $this->fillable);
		$d = '';
		$a1 = 0;
		foreach ($search as $key => $value) {
			if ($a1 > 0) {
				$d .= " OR $key LIKE '$value'";
			}else{
				$d .= " $key LIKE '$value'";
			}
			$a1++;
		}
		$q = DB()->query("SELECT $fillable FROM $this->table WHERE $d", PDO::FETCH_OBJ)->fetchAll();

		return $q;
	}


	public function nextAutoIncrement() {
		return (new table($this->table))->nextAutoIncrement();
	}

}