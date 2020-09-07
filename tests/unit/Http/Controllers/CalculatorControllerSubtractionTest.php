<?php

use Illuminate\Http\Response as HTTP_CODE;



class CalculatorControllerSubtractionTest extends TestCase
{
    /**
     * Subtraction Method test cases
     */
    public function testV1Subtraction_WithoutAnyParameter_ValidationError()
    {
        $inputs = [];
        $expectedAnswer = [
            "error" => [
                "num1" => ["The num1 field is required."],
                "num2"=> ["The num2 field is required."]
            ]
        ];
        
        $response = $this->post('/v1/subtract/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Subtraction_ifNum1IsMissing_ValidationError()
    {
        $num1 = 12;
        $num2 = null;
        $inputs = [
            'num1' => $num1,
            'num2' => $num2
            ];
        $expectedAnswer = [
            "error" => [
                "num2"=> ["The num2 field is required."]
            ]
        ];
        
        $response = $this->post('/v1/subtract/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Subtraction_inputShouldBeNumbers_ValidationError()
    {
        $num1 = "one";
        $num2 = "two";
         $inputs = [
            'num1' => $num1,
            'num2' => $num2
            ];
        $expectedAnswer = [
            "error" => [
                "num1" => ["The num1 must be a number."],
                "num2"=> ["The num2 must be a number."]
            ]
        ];
        
        $response = $this->post('/v1/subtract/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Subtraction_SubtractionOfPositiveNumber_PostiveNumber()
    {
        $num1 = mt_rand(0,9999999999999999);
        $num2 = mt_rand(0,9999999999999999);
        $inputs = [
            'num1' => $num1,
            'num2' => $num2
            ];
        $expectedAnswer = ['answer' => ($num1) - ($num2)];
        
        $response = $this->post('/v1/subtract/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    
    public function testV1Subtraction_SubtractionOfNegativeNumber_ValidationError()
    {
        $num1 = mt_rand(-9999999999999999,0);
        $num2 = mt_rand(-9999999999999999,0);
        $inputs = [
            'num1' => ($num1),
            'num2' => ($num2)
            ];
        $expectedAnswer = [
            "error" => [
                "num1" => ["The num1 must be between 0 and 9999999999999999."],
                "num2"=> ["The num2 must be between 0 and 9999999999999999."]
            ]
        ];
        
        $response = $this->post('/v1/subtract/', $inputs);
        
        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Subtraction_SubtractionOfFloatingNumber_FloatingNumber()
    {
        $num1 = mt_rand(1.2,9999999999999999.0);
        $num2 = mt_rand(1.6,9999999999999999.0);
        $inputs = [
            'num1' => ($num1),
            'num2' => ($num2)
            ];
        $expectedAnswer = ['answer' => ($num1) - ($num2)];
        
        $response = $this->post('/v1/subtract/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    } 
}
