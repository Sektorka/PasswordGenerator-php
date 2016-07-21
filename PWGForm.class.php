<?php

/**
 * @author Sektor
 * @copyright 2013
 */

require "PasswordGenerator.class.php";

class PWGForm extends wxFrame {
	const PWGEN_DAT = "PasswordGenerator.dat";
    
	public function __construct( $parent=null ){
		parent::__construct ( $parent, wxID_ANY, "Password Generator :: by Sektor", wxDefaultPosition, new wxSize( 372,158 ), wxCAPTION|wxCLOSE_BOX|wxMINIMIZE_BOX|wxTAB_TRAVERSAL );
		
        $this->SetIcon(new wxIcon("PasswordGenerator.png", wxBITMAP_TYPE_PNG));
        
		$this->SetSizeHints( wxDefaultSize, wxDefaultSize );
		$this->SetBackgroundColour( wxSystemSettings::GetColour( wxSYS_COLOUR_BTNFACE ) );
		
		$vSizer = new wxBoxSizer( wxVERTICAL );
		
		$hsMutators = new wxBoxSizer( wxHORIZONTAL );
		
		$this->chbUpperCase = new wxCheckBox( $this, wxID_ANY, "Upper case", wxDefaultPosition, wxDefaultSize, 0 );
		$hsMutators->Add( $this->chbUpperCase, 0, wxALL, 5 );
		
		$this->chbLowerCase = new wxCheckBox( $this, wxID_ANY, "Lower case", wxDefaultPosition, wxDefaultSize, 0 );
		$hsMutators->Add( $this->chbLowerCase, 0, wxALL, 5 );
		
		$this->chbNumbers = new wxCheckBox( $this, wxID_ANY, "Numbers", wxDefaultPosition, wxDefaultSize, 0 );
		$hsMutators->Add( $this->chbNumbers, 0, wxALL, 5 );
		
		$this->chbSpecChars = new wxCheckBox( $this, wxID_ANY, "Special chars", wxDefaultPosition, wxDefaultSize, 0 );
		$hsMutators->Add( $this->chbSpecChars, 0, wxALL, 5 );
		
		
		$vSizer->Add( $hsMutators, 1, wxEXPAND, 5 );
		
		$hsPWLenght = new wxBoxSizer( wxHORIZONTAL );
		
		$this->lblLength = new wxStaticText( $this, wxID_ANY, "Password length:", wxDefaultPosition, wxDefaultSize, 0 );
		$this->lblLength->Wrap( -1 );
		$hsPWLenght->Add( $this->lblLength, 0, wxALIGN_BOTTOM|wxALL, 5 );
		
		$this->spPWLength = new wxSpinCtrl( $this, wxID_ANY, wxEmptyString, wxDefaultPosition, new wxSize( 245,20 ), wxSP_ARROW_KEYS, 1, 999, 1 );
		$hsPWLenght->Add( $this->spPWLength, 0, wxALIGN_BOTTOM|wxALL, 5 );
		
		
		$vSizer->Add( $hsPWLenght, 1, wxEXPAND, 5 );
		
		$hsPassword = new wxBoxSizer( wxHORIZONTAL );
		
		$this->lblPassword = new wxStaticText( $this, wxID_ANY, "Password:", wxDefaultPosition, wxDefaultSize, 0 );
		$this->lblPassword->Wrap( -1 );
		$hsPassword->Add( $this->lblPassword, 0, wxALIGN_BOTTOM|wxALL, 5 );
		
		$this->tbPassword = new wxTextCtrl( $this, wxID_ANY, wxEmptyString, wxDefaultPosition, new wxSize( 282,20 ), wxTE_READONLY );
		$this->tbPassword->SetBackgroundColour( wxSystemSettings::GetColour( wxSYS_COLOUR_BTNHIGHLIGHT ) );
        $hsPassword->Add( $this->tbPassword, 0, wxALL, 5 );
		
		
		$vSizer->Add( $hsPassword, 1, wxEXPAND, 5 );
		
		$this->btnGenerate = new wxButton( $this, wxID_ANY, "Generate password", wxDefaultPosition, new wxSize( 350,25 ), 0 );
		$vSizer->Add( $this->btnGenerate, 0, wxALL, 5 );
		
		
		$this->SetSizer( $vSizer );
		$this->Layout();
		
		$this->Centre( wxBOTH );
		
        $objLoad = json_decode(gzuncompress(file_get_contents(self::PWGEN_DAT)));
        
        $this->chbUpperCase->SetValue($objLoad->chbUpperCase);
        $this->chbLowerCase->SetValue($objLoad->chbLowerCase);
        $this->chbNumbers->SetValue($objLoad->chbNumbers);
        $this->chbSpecChars->SetValue($objLoad->chbSpecChars);
        $this->spPWLength->SetValue($objLoad->spPWLength);
        
		$this->btnGenerate->Connect( wxEVT_COMMAND_BUTTON_CLICKED, array($this, "GeneratePassword") );
        
        $this->chbUpperCase->Connect( wxEVT_COMMAND_CHECKBOX_CLICKED, array($this, "SaveState") );
        $this->chbLowerCase->Connect( wxEVT_COMMAND_CHECKBOX_CLICKED, array($this, "SaveState") );
        $this->chbNumbers->Connect( wxEVT_COMMAND_CHECKBOX_CLICKED, array($this, "SaveState") );
        $this->chbSpecChars->Connect( wxEVT_COMMAND_CHECKBOX_CLICKED, array($this, "SaveState") );
        
        $this->spPWLength->Connect( wxEVT_COMMAND_SPINCTRL_UPDATED, array($this, "SaveState") );
		$this->spPWLength->Connect( wxEVT_COMMAND_TEXT_UPDATED, array($this, "SaveState") );
		
	}
	
	
	public function __destruct(){
	   
	}
	
	public function GeneratePassword( $event ){
        $objPWGen = new PasswordGenerator($this->chbUpperCase->GetValue(),
                                          $this->chbLowerCase->GetValue(),
                                          $this->chbNumbers->GetValue(),
                                          $this->chbSpecChars->GetValue(),
                                          $this->spPWLength->getValue()
        );
        
        $this->tbPassword->SetValue($objPWGen->GeneratePassword());
	}
    
    public function SaveState(){
        $arrSave = array(
            "chbUpperCase" => $this->chbUpperCase->GetValue(),
            "chbLowerCase" => $this->chbLowerCase->GetValue(),
            "chbNumbers" => $this->chbNumbers->GetValue(),
            "chbSpecChars" => $this->chbSpecChars->GetValue(),
            "spPWLength" => $this->spPWLength->getValue()
        );
        file_put_contents(self::PWGEN_DAT, gzcompress(json_encode($arrSave),9));
    }
	
}

?>
