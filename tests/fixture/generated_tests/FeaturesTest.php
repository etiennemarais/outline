<?php

/**
 * Generated by OutlineTestGenerator on 2016-02-04 at 10:13:14.
 */
class FeaturesTest extends TestCase
{

    public function testGet_Fetching_credits_available_Returns_200()
    {
        $this->get("/status/credits")
            ->seeJsonStructure(array ( 'status', 'message', 'data', array ( 'credits_available', ), ))
            ->assertResponseStatus(200);
    }

    public function testGet_Fetching_credits_available_Returns_402()
    {
        $this->get("/status/credits")
            ->seeJsonStructure(array ( 'status', 'message', 'data', array ( 'credits_available', 'min_threshold', ), ))
            ->assertResponseStatus(402);
    }

    public function testGet_Fetching_credits_available_Returns_401()
    {
        $this->get("/status/credits")
            ->seeJsonStructure(array ( 'status', 'message', ))
            ->assertResponseStatus(401);
    }

    public function testPost_Resending_a_code_Returns_200()
    {
        $this->post("/code/resend")
            ->seeJsonStructure(array ( 'status', 'message', 'data', array ( 'verification_status', 'expires_at', array ( 'date', 'timezone_type', 'timezone', ), ), ))
            ->assertResponseStatus(200);
    }

    public function testPost_Resending_a_code_Returns_400()
    {
        $this->post("/code/resend")
            ->seeJsonStructure(array ( 'status', 'message', ))
            ->assertResponseStatus(400);
    }

    public function testPost_Resending_a_code_Returns_401()
    {
        $this->post("/code/resend")
            ->seeJsonStructure(array ( 'status', 'message', ))
            ->assertResponseStatus(401);
    }

    public function testPost_Resending_a_code_Returns_406()
    {
        $this->post("/code/resend")
            ->seeJsonStructure(array ( 'status', 'message', 'data', array ( 'required_format', ), ))
            ->assertResponseStatus(406);
    }

}
