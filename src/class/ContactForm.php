<?php

class ContactForm extends DbObject {
    public $id;
	public $fullname;
	public $phone;
	public $email;
	public $message;
	public $created_at;
}

Class User extends DbObject {
	public $id;
	public $nom; 
	public $prenom;
	public $email;
	public $telephone;
	public $date_de_naissance;
	public $motdepasse;
	public $role;

}

Class Compte extends DbObject {
   public $id_cmpt;
   public $numero; 
   public $id_user;
   public $id_monaie;
   public $solde;
}

?>