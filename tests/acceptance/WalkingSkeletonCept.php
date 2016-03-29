<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('start the test cycle');

$I->amOnPage("/workouts");
$I->see("28.03.2016");
