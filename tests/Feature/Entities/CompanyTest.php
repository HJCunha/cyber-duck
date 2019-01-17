<?php

namespace Tests\Feature\Entities;

use App\Http\Controllers\CompanyController;
use App\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected $_data = [];
    protected $_credential = [];
    protected $_user = [];

    public function setUp()
    {
        $this->_data = ["name" => "Test Name", "firstName" => "Test", "lastName" => "Name", "email" => "test@test.com", "website" => "https://test.com"];
        $this->_credential = [
            'email' => 'admin@admin.com',
            'password' => 'password'
        ];

        $this->_user = new User($this->_credential);

        parent::setUp();
    }

    /**
     * CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
     */
    public function test_crud_companies()
    {
        $this->be($this->_user);
        $resp = $this->post('/insert-data-companies', $this->_data)->assertStatus(201);

        $created = json_decode($resp->getContent(), true);

        $this->_data["name"] = "New name";

        $resp = $this->post('/update-data-companies/' . $created["id"], $this->_data)->assertStatus(200);
        $updated = json_decode($resp->getContent(), true);

        $this->assertEquals($updated["name"], $this->_data["name"]);

        $this->get('/delete-data-companies?id=' . $created["id"], $this->_data)->assertStatus(200);
    }

    /**
     * CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
     */
    public function test_crud_employees()
    {
        $this->be($this->_user);
        $resp = $this->post('/insert-data-employees', $this->_data)->assertStatus(201);

        $created = json_decode($resp->getContent(), true);

        $this->_data["firstName"] = "New First name";

        $resp = $this->post('/update-data-employees/' . $created["id"], $this->_data)->assertStatus(200);
        $updated = json_decode($resp->getContent(), true);

        $this->assertEquals($updated["firstName"], $this->_data["firstName"]);

        $this->get('/delete-data-employees?id=' . $created["id"], $this->_data)->assertStatus(200);
    }
}
