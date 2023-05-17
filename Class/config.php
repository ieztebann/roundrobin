<?php

class config {

    public $id;
    public $tittle = "Algoritmo Round Robin";
    public $powered_by = "Esteban Bohorquez Rodriguez";
    public $array_test;
    public $date_now;

    public function __construct($date_time = 'a') {
        if (!empty($date_time)) {
            $this->start($date_time); /* Inicio de programa */
        }
    }

    public function start($date_time = '') {
        if ($date_time) {
            $this->date_now = $date_time; /* Inicio de visualización de la prueba */

            $test = array();
            $test[] = Array('value' => '1', 'name' => 'Secuencia Fibonacci', 'function' => 'secuenceF', 'parms' => 'false', 'function_parms' => '');
            $test[] = Array('value' => '3', 'name' => 'Escalera de asteriscos invertida', 'function' => 'showLadderInv', 'parms' => 'true', 'function_parms' => 'show_amount');
            $test[] = Array('value' => '2', 'name' => 'Escalera de asteriscos', 'function' => 'showLadder', 'parms' => 'true', 'function_parms' => 'show_amount');
            $test[] = Array('value' => '4', 'name' => 'Número mayor y menor', 'function' => 'majorAndMinor', 'parms' => 'true', 'function_parms' => 'show_20_fields');
            $test[] = Array('value' => '6', 'name' => 'Ovejas', 'function' => 'sheep', 'parms' => 'false', 'function_parms' => 'show_select');
            $test[] = Array('value' => '5', 'name' => 'Hallar el perímetro y área', 'function' => 'perimeterAndArea', 'parms' => 'true', 'function_parms' => 'show_select');
            $test[] = Array('value' => '7', 'name' => 'Taller de Papá Noel', 'function' => 'santaWorkHouse', 'parms' => 'false', 'function_parms' => 'show_select');
            $test[] = Array('value' => '8', 'name' => 'Lista de contactos', 'function' => 'contactList', 'parms' => 'false', 'function_parms' => 'show_select');
            $test[] = Array('value' => '9', 'name' => 'Algoritmo Round Robin', 'function' => 'showRoundRobin', 'parms' => 'true', 'function_parms' => 'show_robin_pars');
            
            $this->array_test = ($test);
        }
    }

    function show_test_list() {
        return $this->array_test;
    }

    function show_function($id = 0) {
        if ($id) {
            $data = (object) $this->show_test_list();
            if (is_object($data)) {
                foreach ($data as $value) {
                    if ((Integer) $value['value'] == (Integer) $id) {
                        return $value['function'];
                    }
                }
            }
        }

        return false;
    }

    function show_function_parms($id = 0) {
        if ($id) {
            $data = (object) $this->show_test_list();
            if (is_object($data)) {
                foreach ($data as $value) {
                    if ((Integer) $value['value'] == (Integer) $id) {
                        return $value['function_parms'];
                    }
                }
            }
        }

        return false;
    }

    function show_parms($id = 0) {
        if ($id) {
            $data = (object) $this->show_test_list();
            if (is_object($data)) {
                foreach ($data as $value) {
                    if ((Integer) $value['value'] == (Integer) $id) {
                        return $value['parms'];
                    }
                }
            }
        }

        return false;
    }

}

?>