<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'datatables_demo' )
	->fields(
		Field::inst( 'id' ),
		Field::inst( 'first_name' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'A first name is required' )	
			) ),
		Field::inst( 'last_name' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'A last name is required' )	
			) ),
		Field::inst( 'source_language' ),
		Field::inst( 'target_language' ),
		Field::inst( 'email' )
			->validator( Validate::email( ValidateOptions::inst()
				->message( 'Please enter an e-mail address' )	
			) ),
		Field::inst( 'type' ),
		Field::inst( 'service' ),
		Field::inst( 'expertise' ),
		Field::inst( 'rate' )
			->validator( Validate::numeric() )
			->setFormatter( Format::ifEmpty(null) ),
		Field::inst( 'unit' ),
		Field::inst( 'native_language' ),
		Field::inst( 'status' ),
		Field::inst( 'location' ),
		Field::inst( 'phone' ),
		Field::inst( 'email' ),
		Field::inst( 'skype' ),
		Field::inst( 'age' )
			->validator( Validate::numeric() )
			->setFormatter( Format::ifEmpty(null) ),
		Field::inst( 'salary' )
			->validator( Validate::numeric() )
			->setFormatter( Format::ifEmpty(null) ),
		Field::inst( 'gender' ),
		Field::inst( 'dob' )
			->validator( Validate::dateFormat( 'Y-m-d' ) )
			->getFormatter( Format::dateSqlToFormat( 'Y-m-d' ) )
			->setFormatter( Format::dateFormatToSql('Y-m-d' ) ),
		Field::inst( 'availability' ),
		Field::inst( 'rating' ),
		Field::inst( 'link_cv' ),
		Field::inst( 'lastest_support' )
			->validator( Validate::dateFormat( 'Y-m-d' ) )
			->getFormatter( Format::dateSqlToFormat( 'Y-m-d' ) )
			->setFormatter( Format::dateFormatToSql('Y-m-d' ) ),
		Field::inst( 'number_supported' )
			->validator( Validate::numeric() )
			->setFormatter( Format::ifEmpty(null) )
	)
	->process( $_POST )
	->json();
