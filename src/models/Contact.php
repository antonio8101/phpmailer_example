<?php

namespace Abruno\PhpMailer\Models;

class Contact {

	public string $address;

	public string $name;

	public Contact $replyTo;

	public function __construct( $name, $address ) {

		$this->name    = $name;
		$this->address = $address;
	}

}