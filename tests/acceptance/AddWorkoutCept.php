<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('add a new workout');

$I->amOnPage("workouts/add");

$I->fillField("Date", "18.02.2017");
$I->fillField("Start", "11:00");
$I->fillField("End", "12:25");
$I->click("Add");

$I->dontSeeInCurrentUrl("workouts/add");
$I->see("18.02.2017");