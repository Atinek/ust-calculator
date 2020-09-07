<?php

use Illuminate\Http\Response as HTTP_CODE;



class CalculatorControllerMultiplicationTest extends TestCase
{
    /**
     * Multiplication Method Test case start
     */
    public function testV1Multiplication_WithoutAnyParameter_ValidationError()
    {
        $inputs = [];
        $expectedAnswer = [
            "error" => [
                "num1" => ["The num1 field is required."],
                "num2"=> ["The num2 field is required."]
            ]
        ];
        
        $response = $this->post('/v1/multiply/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Multiplication_ifNum1IsMissing_ValidationError()
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
        
        $response = $this->post('/v1/multiply/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Multiplication_SumOfPositiveNumber_PostiveNumber()
    {
        $num1 = mt_rand(0,9999999999999999);
        $num2 = mt_rand(0,9999999999999999);
        $inputs = [
            'num1' => $num1,
            'num2' => $num2
            ];
        $expectedAnswer = ['answer' => ($num1) * ($num2)];
        
        $response = $this->post('/v1/multiply/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    
    public function testV1Multiplication_SumOfNegativeNumber_ValidationError()
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
        
        $response = $this->post('/v1/multiply/', $inputs);
        
        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
    public function testV1Multiplication_SumOfFloatingNumber_FloatingNumber()
    {
        $num1 = mt_rand(1.2,9999999999999999.0);
        $num2 = mt_rand(1.6,9999999999999999.0);
        $inputs = [
            'num1' => ($num1),
            'num2' => ($num2)
            ];
        $expectedAnswer = ['answer' => ($num1) * ($num2)];
        
        $response = $this->post('/v1/multiply/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_OK, $response->response->status());
    }
    
    public function testV1Multiplication_inputShouldBeNumbers()
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
        
        $response = $this->post('/v1/multiply/', $inputs);

        $this->assertEquals(json_encode($expectedAnswer), $response->response->content());
        $this->assertEquals(HTTP_CODE::HTTP_UNPROCESSABLE_ENTITY, $response->response->status());
    }
    
}
