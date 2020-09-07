<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HTTP_CODE;
use Illuminate\Http\Exceptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;


class CalculatorController extends Controller
{
    

    /**
     * Add two values and returns the addition of 2 values
     * 
     * @param Request $request
     * @return JSON Array Description
     */
    public function v1Addition(Request $request)
    {
        // validating the inputs 
        $this->validate($request, [
            'num1' => "required|numeric|between:0,9999999999999999",
            'num2' => 'required|numeric|between:0,9999999999999999',
        ]);
        
        $num1 = $request->get('num1');
        $num2 = $request->get('num2');
        
        try 
        {
            Log::info("values to be added :",$request->all());
            $result = $num1 + $num2;
            $response = ["answer" => $result];
            Log::info("Sum of two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_OK;
            
        } 
        catch (\Exception $exception) {
            $response = ['error' => [$exception->getMessage()]];
            Log::error("Error while adding two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    public function v1Subtraction(Request $request)
    {
        // validating the inputs 
        $this->validate($request, [
            'num1' => 'required|numeric|between:0,9999999999999999',
            'num2' => 'required|numeric|between:0,9999999999999999',
        ]);
        
        $num1 = $request->get('num1');
        $num2 = $request->get('num2');
        
        try 
        {
            Log::info("values to be subtracted :",$request->all());
            $response = ["answer" => $num1 - $num2];
            Log::info("Difference of two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_OK;
        } 
        catch (\Exception $exception) {
            $response = ['error' => [$exception->getMessage()]];
            Log::error("Error while subtracting two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    public function v1Multiplication(Request $request)
    {
        // validating the inputs 
        $this->validate($request, [
            'num1' => 'required|numeric|between:0,9999999999999999',
            'num2' => 'required|numeric|between:0,9999999999999999',
        ]);
        
        $num1 = $request->get('num1');
        $num2 = $request->get('num2');
        
        
        try 
        {
            Log::info("values to be multipled :",$request->all());
            $response = ["answer" => $num1 * $num2];
            Log::info("Product of two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_OK;
        } 
        catch (\Exception $exception) {
            $response = ['error' => [$exception->getMessage()]];
            Log::error("Error while multiplying two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    public function v1Division(Request $request)
    {
        // validating the inputs 
        $this->validate($request, [
            'num1' => 'required|numeric|between:0,9999999999999999',
            'num2' => 'required|numeric|between:0,9999999999999999',
        ]);
        
        $num1 = $request->get('num1');
        $num2 = $request->get('num2');
        
        
        try 
        {
            Log::info("values to be divided :",$request->all());
            $response = ["answer" => $num1 / $num2];
            Log::info("Result: ", ($response));
            $httpCode = HTTP_CODE::HTTP_OK;
        } 
        catch (\ErrorException $exception) {
            $response = ['error' => ["Cannot divide by zero"]];
            Log::error("Divide by zero: ", ($response));
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        catch (\Exception $exception) {
            $response = ['error' => [$exception->getMessage()]];
            Log::error("Error while dividing two values: ", ($response));
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    public function v1SquareRoot(Request $request)
    {
        // validating the inputs 
        $this->validate($request, [
            'num1' => 'required|numeric|between:1,9999999999999999'
        ]);
        
        $num1 = $request->get('num1');
        
        try 
        {
            Log::info("Need to find square root of  :",$request->all());
            $response = ["answer" => round(sqrt($num1), 4) ];
            Log::error("SquareRoot Result: ", ($response));
            $httpCode = HTTP_CODE::HTTP_OK;
        } 
        catch ( Exceptions $exception) {
            $response = ['error' => [$exception->getMessage()]];
            Log::error("Error while finding SquareRoot", ($response));
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    
    public function v1SaveValue(Request $request)
    {
        // validating the inputs 
        $this->validate($request, [
            'value' => 'required|numeric|between:1,99999999'
        ]);
        
        $num1 = $request->get('value');
        
        try 
        {
            $fileName = (string)(md5($request->ip()));
            Log::info("Value needs to saved :",$request->all());
            Storage::disk('local')->put($fileName, json_encode(["value" => $num1]));
            
            $response = ["save" => true  ];
            $httpCode = HTTP_CODE::HTTP_OK;
        } 
        catch ( ErrorException $exception) {
            $response = ['error' => [$exception->getMessage()]];
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    public function v1GetValue(Request $request)
    {
        try 
        {
            $fileName = (string)(md5($request->ip()));
            $value = Storage::disk('local')->get($fileName);
            
            $response = ["value" => json_decode($value, true)['value']];
            $httpCode = HTTP_CODE::HTTP_OK;
        }
        catch (FileNotFoundException  $exception) {
            $response = ['error' => ["there is no value saved"]];
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        catch ( Exceptions $exception) {
            $response = ['error' => [$exception->getMessage()]];
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    public function v1ClearValue(Request $request)
    {
        // validating the inputs 
        try 
        {
            $fileName = (string)(md5($request->ip()));
            $value = Storage::disk('local')->delete($fileName);
            
            $response = ["value" => null];
            $httpCode = HTTP_CODE::HTTP_OK;
        } 
        catch ( Exceptions $exception) {
            $response = ['error' => [$exception->getMessage()]];
            $httpCode = HTTP_CODE::HTTP_BAD_REQUEST;
        }
        return response()->json($response, $httpCode);
    }
    
    
    
    
    
    
    
}
