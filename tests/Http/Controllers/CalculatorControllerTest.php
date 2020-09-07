<?php

use Illuminate\Http\Response as HTTP_CODE;



class CalculatorControllerTest extends TestCase
{
    public function testV1SquareRoot_EmptyInputs_ValidationError()
    {
        $inputs = [];
        $expectedAnswer = [
            "error" => [
                "num1" => ["The num1 field is required."]
            ]
        ];
        
        $response = $this->post('/v1/squareRoot/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1SquareRoot_StringValue_ValidationError()
    {
        $inputs = ["num1" => "atinek"];
        $expectedAnswer = [
            "error" => [
                "num1" => ["The num1 must be a number."]
            ]
        ];
        
        $response = $this->post('/v1/squareRoot/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1SquareRoot_NumericValue_JsonArray()
    {
        $inputs = ["num1" => 61];
        $expectedAnswer = [
            "answer" => 7.8102
        ];
        
        $response = $this->post('/v1/squareRoot/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    
    public function testV1SaveValue_EmptyInputs_ValidationError()
    {
        $inputs = [];
        $expectedAnswer = [
            "error" => [
                "value" => ["The value field is required."]
            ]
        ];
        
        $response = $this->post('/v1/save/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1SaveValue_StringValue_ValidationError()
    {
        $inputs = ["value" => "atinek"];
        $expectedAnswer = [
            "error" => [
                "value" => ["The value must be a number."]
            ]
        ];
        
        $response = $this->post('/v1/save/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1SaveValue_NumericValue_JsonArray()
    {
        $inputs = ["value" => 50];
        $expectedAnswer = [
            "save" => true
        ];
        
        $response = $this->post('/v1/save/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    
    public function testV1GetValue_RetriveSavedValue_JsonArray()
    {
        $expectedAnswer = [
            "value" => 50
        ];
        
        $response = $this->get('/v1/savedValue/');

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    public function testV1ClearValue_JsonArray()
    {
        $expectedAnswer = [
            "value" => null
        ];
        
        $response = $this->post('/v1/clear/');

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    
    
}
