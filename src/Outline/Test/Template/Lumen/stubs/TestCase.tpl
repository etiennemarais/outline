
    public function test{methodLabel}_{methodName}()
    {
        $call = $this->{method}("{endpoint}", {requestData}{requestHeaders});
        $call->{seeJsonStructure};
        $call->assertResponseStatus({statusCode});
    }