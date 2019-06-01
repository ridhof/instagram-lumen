<?php
class UserTest extends TestCase
{
    /**
     * /products [GET]
     */
    public function testShouldReturnAllUser(){
        $this->get("/api/v1/user/users", []);
        $this->seeStatusCode(200);
    }
}