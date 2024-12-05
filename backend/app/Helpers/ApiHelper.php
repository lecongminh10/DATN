<?php

namespace App\Helpers;

use App\Models\Address;
use App\Models\Carrier;
use Illuminate\Support\Facades\Auth;

class ApiHelper {

    public static function getAddressShop()
    {

        $activeApiToken = Carrier::where('is_active', 'active')
                         ->first(); 

        if (!$activeApiToken) {
            return response()->json(['message' => 'No active carriers found'], 404);
        }

        if($activeApiToken->name==Carrier::GHN){
           return ApiHelper::fetchDeliveryAddressesGHN($activeApiToken->api_token);
        }
    }

    public static function getToken()
    {
        $activeApiToken = Carrier::where('is_active', 'active')
        ->first(); 

        if (!$activeApiToken) {
           return response()->json(['message' => 'No active carriers found'], 404);
        }

        if($activeApiToken->name==Carrier::GHN){
           return $activeApiToken->api_token;
        }
    }


    //Lấy địa chỉ của cửa hàng 
    public static function fetchDeliveryAddressesGHN($token) {

        $url = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shop/all';
        $data = [
            "offset" => 0,
            "limit" => 50,
            "client_phone" => ""
        ];

        $headers = [
            "Content-Type: application/json",
            "Token: $token",
            "ShopId: 5335847",
        ];

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['code']) && $responseData['code'] !== 200) {
            return null;
        }
        return $responseData;
    }

    private static function makeApiRequest($url, $method = "GET", $data = null , $shopId=null)
    {
        $token = self::getToken();
        $headers = [
            "Content-Type: application/json",
            "Token: $token",
            "ShopId: $shopId"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
        

        if ($method == "POST" && $data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
        }
        
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

    
        if (isset($responseData['code']) && $responseData['code'] !== 200) {
            return null;
        }

        return $responseData;
    }


    public static function getApiCity()
    {
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/province';
        return self::makeApiRequest($url);
    }


    public static function getApiDistrict($id_city)
    {
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/district';
        $data = ["province_id" => $id_city];
        return self::makeApiRequest($url, "POST", $data);
    }


    public static function getApiWard($id_district)
    {
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id';
        $data = ['district_id' => $id_district];
        return self::makeApiRequest($url, "POST", $data);
    }
    
    
    public static function getApiDistrictWard()
    {
        $id = Auth::id();
        $address = Address::getActiveAddress($id);
        
        if (!$address || empty($address->city)) {
            return null;
        }
    
        $provinceData = self::getApiCity();
    
        if (!$provinceData || !isset($provinceData['data'])) {
            return null;
        }
        $dataApi = [];
        foreach ($provinceData['data'] as $province) {

            $normalizedCity = preg_replace('/^(Thành phố|Tỉnh)\s+/i', '', $address->city);
            $normalizedProvinceName = preg_replace('/^(Thành phố|Tỉnh)\s+/i', '', $province['ProvinceName']);
        

            if (stripos($normalizedProvinceName, $normalizedCity) !== false || stripos($normalizedCity, $normalizedProvinceName) !== false) {

                $districts = ApiHelper::getApiDistrict($province['ProvinceID']);
        
                foreach ($districts['data'] as $district) {

                    if (stripos($district['DistrictName'], $address->district) !== false) {
                        $dataApi['DistrictID'] = $district['DistrictID'];
                        $wards = ApiHelper::getApiWard($district['DistrictID']);
                        
                        foreach ($wards['data'] as $ward) {
    
                            if (stripos($ward['WardName'], $address->ward) !== false) {
                                $dataApi['WardID'] = $ward['WardCode'];
                                break; 
                            }
                        }

                        if (isset($dataApi['WardID'])) {
                            break;
                        }
                    }
                }

                if (isset($dataApi['WardID'])) {
                    break;
                }
            }
        }
        
        if (!isset($dataApi['WardID'])) {
            return null;
        }      
        return $dataApi;        
    }

    public static function calculateServiceFee($type , $totalWeight, $items) {
        $shopInfo = ApiHelper::fetchDeliveryAddressesGHN( self::getToken());
        $customerInfo= ApiHelper::getApiDistrictWard(); 

        $url = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee';
        $shopId = '5335847';  
        
        if (isset($shopInfo['data']) && is_array($shopInfo['data'])) {

            foreach ($shopInfo['data'] as $key=> $address) {
                if($key=="shops"){
                    foreach($address as $addre){
                        $fromDistrictId = $addre['district_id'] ?? null;
                        $fromWardCode = $addre['ward_code'] ?? null;
                    }
                }                
                
            }
        }
        if($customerInfo !==null)
        {
            $toDistrictId = $customerInfo['DistrictID'];
            $toWardCode = $customerInfo['WardID'];
        } else
        {
            $toDistrictId = 0;
            $toWardCode = 0;
        }

        $weight = $totalWeight;
        $data = [
            "service_type_id" => $type, 
            "from_district_id" => $fromDistrictId,
            "from_ward_code" => $fromWardCode,
            "to_district_id" => $toDistrictId,
            "to_ward_code" => $toWardCode,
            "height" =>0,
            "length" =>0,
            "weight" => $weight,
            "width" => 0,
            "insurance_value" => 0,
            "coupon" => null,
            "items" => $items,
        ];
    
        $responseData = self::makeApiRequest($url, 'POST', $data , $shopId);
    
        if ($responseData && isset($responseData['data']['service_fee'])) {
            $shippingFee = $responseData['data']['service_fee'];
            return $shippingFee;
        } else {
            return null;
        }
    }
    
    
}
