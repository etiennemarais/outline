
    public function test{methodLabel}_{methodName}()
    {
        $this->{method}("{endpoint}")
            {seeJsonStructure}
            ->assertResponseStatus({statusCode});
    }