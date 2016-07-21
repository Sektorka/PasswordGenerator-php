<?php

/**
 * @author Sektor
 * @copyright 2013
 */
 
require "PWGForm.class.php";

class PWGApp extends wxApp 
{
	public function OnInit()
	{
		$PWGForm = new PWGForm();
		$PWGForm->Show();
		
		$this->frm = $PWGForm;
		
		return true;
	}
	
	public function OnExit()
	{
		return 0;
	}
}

?>