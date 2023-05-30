<?php
header("Content-Type:application/json");

class Tournament{
   public $MP = [];
   public $W = [];
   public $D = [];
   public $L = [];
   public $P = [];

   public function __construct($score){
      $this->equipos = explode(";", $score);
   }

   public function validateEquipos($arg){
      $equiposFaltantes = array_diff_key($this->MP, $arg);
      
      foreach ($equiposFaltantes as $key => $value) {
         switch ($arg) {
            case $this->W:
               $arg[$key] = 0;
               $this->W = $arg;
               break;
            case $this->D:
               $arg[$key] = 0;
               $this->D = $arg;
               break;
            case $this->L:
               $arg[$key] = 0;
               $this->L = $arg;
               break;
            case $this->P:
               $arg[$key] = 0;
               $this->P = $arg;
               break;
         }
         
      }
   }

   public function asignacionPuntos(){
      foreach ($this->equipos as $key => $value) {
         if($key%3 == 2){
            switch ($this->equipos[$key]) {
               case 'win':
                  $equipo1 = $this->equipos[$key - 2];
                  $equipo2 = $this->equipos[$key - 1];

                  ($this->W[$equipo1] ?? null) ?$this->W[$equipo1]+=1 :$this->W[$equipo1] = 1; 
                  ($this->L[$equipo2] ?? null) ?$this->L[$equipo2]+=1 :$this->L[$equipo2] = 1; 

                  ($this->P[$equipo1] ?? null) ?$this->P[$equipo1]+=3 :$this->P[$equipo1] = 3; 
                  break;
               
               case 'draw':
                  $equipo1 = $this->equipos[$key - 1];
                  $equipo2 = $this->equipos[$key - 2];

                  ($this->D[$equipo1] ?? null) ?$this->D[$equipo1]+=1 :$this->D[$equipo1] = 1; 
                  ($this->D[$equipo2] ?? null) ?$this->D[$equipo2]+=1 :$this->D[$equipo2] = 1; 

                  ($this->P[$equipo1] ?? null) ?$this->P[$equipo1]+=1 :$this->P[$equipo1] = 1; 
                  ($this->P[$equipo2] ?? null) ?$this->P[$equipo2]+=1 :$this->P[$equipo2] = 1; 
                     break;
               case 'loss':
                  $equipo1 = $this->equipos[$key - 1];
                  $equipo2 = $this->equipos[$key - 2];

                  ($this->W[$equipo1] ?? null) ?$this->W[$equipo1]+=1 :$this->W[$equipo1] = 1; 
                  ($this->L[$equipo2] ?? null) ?$this->L[$equipo2]+=1 :$this->L[$equipo2] = 1; 

                  ($this->P[$equipo1] ?? null) ?$this->P[$equipo1]+=3 :$this->P[$equipo1] = 3; 
                  break;
            }
         } else{
            ($this->MP[$this->equipos[$key]] ?? null) ?$this->MP[$this->equipos[$key]] +=1 : $this->MP[$this->equipos[$key]] =1;
         }
      }
      $this->validateEquipos($this->W);
       $this->validateEquipos($this->D);
      $this->validateEquipos($this->L);
      $this->validateEquipos($this->P); 
   }
}

$obj =  new Tournament("Allegoric Alaskans;Blithering Badgers;win;Devastating Donkeys;Courageous Californians;draw;Devastating Donkeys;Allegoric Alaskans;win;Courageous Californians;Blithering Badgers;loss;Blithering Badgers;Devastating Donkeys;loss;Allegoric Alaskans;Courageous Californians;win");
$obj->asignacionPuntos();

function printRow($team, $mp, $w, $d, $l, $p) {
   $row = sprintf("%-30s | %-2s | %-2s | %-2s | %-2s | %-2s", $team, $mp, $w, $d, $l, $p);
   echo $row . PHP_EOL;
}

printRow("Team", "MP", "W", "D", "L", "P");
foreach ($obj->MP as $team => $mp) {
   printRow($team, $mp, $obj->W[$team], $obj->D[$team], $obj->L[$team], $obj->P[$team]);
}
/* echo json_encode($obj->MP, JSON_PRETTY_PRINT);
echo json_encode($obj->W, JSON_PRETTY_PRINT);
echo json_encode($obj->D, JSON_PRETTY_PRINT);
echo json_encode($obj->L, JSON_PRETTY_PRINT);
echo json_encode($obj->P, JSON_PRETTY_PRINT); */
?>