
    public function test{methodLabel}_{methodName}()
    {
        $this->{method}("{endpoint}", {requestData}, {requestHeaders})
            {seeJsonStructure}
            ->assertResponseStatus({statusCode});
    }