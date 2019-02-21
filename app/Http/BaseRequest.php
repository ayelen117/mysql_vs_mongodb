<?php

namespace App\Http;

use Illuminate\Http\Request;

class BaseRequest extends Request
{

    //usuario logueado
    protected $user_id;

    //Company enviada en la url
    protected $company_id;

    //Valores por defecto, que se agregan a la peticion
    protected $defaultValues = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        JWTAuth::setRequest($this);
//        $this->user_id = JWTAuth::parseToken()->authenticate()->id;
//        //Si viene el company ID por defecto va en los attributos
//        $routesParams = $this->route()->parameters();
//        $company_id = null;
//        if (isset($routesParams['company_id'])) {
//            $company_id = $routesParams['company_id'];
//        }
//        $this->company_id = $company_id;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

//    //Tomo los atributos
//    protected function getValidateAttributes($resource)
//    {
//        $attributes = (new ValidateRequest())->checkAttributes($this);
//        $attributes = $this->validateResource($attributes, $resource);
//
//        return $attributes;
//    }

//    protected function getAttributes()
//    {
//
//        $attributes = (new ValidateRequest())->checkAttributes($this);
//
//        return $attributes;
//    }

    //    todo: rename to getRelationship() , unificar con la función getRelation() de ValidateRequest
    protected function getRelation($resource, $isRequired = false, $default = null, $returnDefault = false)
    {

        if ($isRequired) {
            if (!isset($this['data']['relationships'][$resource]['data'])) {
                throw (new BaseException())->setModel('Relationship '.$resource.' resource not exist.');
            }

            if (!$this['data']['relationships'][$resource]['data']) {
                throw (new BaseException())->setModel('Relationship '.$resource.' resource is empty.');
            }
        } else {
            if (!isset($this['data']['relationships'][$resource]['data'])) {
                if ($returnDefault) {
                    return $default;
                } else {
                    return [];
                }
            }
        }

        $ids = null;
        $data = $this['data']['relationships'][$resource]['data'];
        if (count($data) != count($data, 1)) { //todo:  modificar chequeo
            //Soy array
            foreach ($data as $var) {
                if (isset($var['id'])) {
                    if (!isset($var['type'])) {
                        $ids[] = $var['id'];
                    } else {
                        if ($var['type'] == $resource) {
                            $ids[] = $var['id'];
                        }
                    }
                }
            }
        } else { // todo: en que caso se da esto?
            if (isset($data['id'])) {
                $ids = $data['id'];
            }
        }


        //En el caso de que quiera setear un valor default
        if ($ids == null && $default !== null) {
            return (int) $default;
        }

        return $ids;
    }

    //Funcion para obtener el id de un relashinship
    protected function getRelationAttributeId($resource)
    {
        $request = $this;

        if (!isset($request['data']['relationships'][$resource]['data']['id'])) {
            throw (new BaseException())->setModel('Relationship '.$resource.' resource not exist.');
        }

        if (!$request['data']['relationships'][$resource]['data']['id']) {
            throw (new BaseException())->setModel('Relationship '.$resource.' resource is empty.');
        }

        return $request['data']['relationships'][$resource]['data']['id'];
    }

    //Busco el id de una posible relacion que puede no existir
    protected function getPossiblyRelationId($resource)
    {
        if (!isset($this['data']['relationships'][$resource]['data']['id'])) {
            return null;
        }

        return $this['data']['relationships'][$resource]['data']['id'];
    }

    //Tomo los include que yo pida validados
    protected function getValidateInclude($resource)
    {
        $request = $this;

        if (!isset($request['included'])) {
            throw (new BaseException)->setModel('El recurso `included` no existe.');
        }

        if (!is_array($request['included'])) {
            throw (new BaseException)->setModel('El recurso `included` no es un array.');
        }

        $included = $request['included'];

        $includeArray = [];
        foreach ($included as $include) {
            if ($include['type'] == $resource) {
                $attribute = $include['attributes'];
                $attribute = $this->validateResource($attribute, $resource);
                $includeArray[] = $attribute;
            }
        }

        return $includeArray;
    }

    //Tomo los include de un resource particular, sin validacion
    protected function getInclude($resource)
    {
        $request = $this;
        $includeArray = [];
        if (isset($request['included'])) {
            $included_items = $request['included'];

            foreach ($included_items as $include_item) {
                if (isset($include_item['id'])) {
                    $id = $include_item['id'];
                }

                if ($include_item['type'] == $resource) { // todo:verificar
                    $attribute = $include_item['attributes'];
                    $attribute['id'] = $id;
                    $attribute = array_merge($attribute, $this->defaultValues);

                    $includeArray[] = $attribute;
                }
            }
        }

        return $includeArray;
    }


    //Include seria cuando se quiere enviar un include resource
    protected function getIncludeParam()
    {
        if (!isset($this['include'])) {
            return 0;
        }

        return $this['include'];
    }

    //Se llama el array filter que trae esta request
    protected function getFilterParam()
    {
        if (!isset($this['filter'])) {
            return 0;
        }

        $filter = $this['filter'];

        return $filter;
    }

    //Valido el resource segun archivos de configuracion
    protected function validateResource($attributes, $resource)
    {
        $attributes = array_merge($attributes, $this->defaultValues);
        $rulesAttributes = ValidationsRules::getRequestValidationsRules($resource);

        if ($resource == 'products') {
            $rulesAttributes = $this->excludeReplacementCostIfIsVariantCommon($attributes, $rulesAttributes);
        }

        $validator = Validator::make($attributes, $rulesAttributes);
        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }
        //Busco el archivo de configuracion, con el filled resource para intercambiar valores
        $filled = config('filled.'.$resource);
        //Me fijo si existe el config para hacer el fill de este attributo
        if (!empty($filled)) { // todo : ($filled)
            $attributes = $this->fillRequest($attributes, $filled);
        }

        return $attributes;
    }

    //Saber tipo de receipt segun order
    protected function setOrderReceiptId($receipt_type)
    {
        if ($receipt_type == 'order_sell') {
            $return = 69;
        } elseif ($receipt_type == 'order_buy') {
            $return = 82;
        } else {
            throw (new BaseException())->setModel('The receipt type is not valid.');
        }

        return $return;
    }

    //Seteo los valores por default
    protected function setDefaultValues($defaultValues)
    {
        $this->defaultValues = $defaultValues;
    }

    //Esta funcion sirve para cuando el usuario del api enviar un valor
    //Pero el backend lo interpreta de otra forma
    //parsea los nombres de los atrributos
    protected function fillRequest($attributes, $parseArray)
    {

        foreach ($attributes as $a => $k) {
            foreach ($parseArray as $p => $v) {
                if ($a == $p) {
                    $attributes[$v] = $k;
                    unset($attributes[$a]);
                }
            }
        }

        return $attributes;
    }

    public function getRequestAttribute($request, $field)
    {
        $attribute = null;
        if (isset($request['data']['attributes'][$field])) {
            $attribute = $request['data']['attributes'][$field];
        }

        return $attribute;
    }


    /**
     * @param $included
     *
     * @return bool
     * Se crean lo pricelistProduct que vienen de product en include
     */
    public function includedPricelistProduct($included, $product_id)
    {

        $attributesArrays = [];
        foreach ($included as $var) {
            $attributes = $var;
            $attributes['product_id'] = $product_id;

            $priceType = 'auto';
            if (isset($attributes['price_type'])) {
                $priceType = $attributes['price_type'];
            }

            $percentSubdistType = 'auto';
            if (isset($attributes['percent_subdist_type'])) {
                $percentSubdistType = $attributes['percent_subdist_type'];
            }

            $percentPreventType = 'auto';
            if (isset($attributes['percent_seller_type'])) {
                $percentPreventType = $attributes['percent_seller_type'];
            }

            $price = 0;
            $percent_subdist = 0;
            $percent_prevent = 0;

            if (isset($attributes['price'])) {
                $price = $attributes['price'];
            }

            if (isset($attributes['percent_subdist'])) {
                $percent_subdist = $attributes['percent_subdist'];
            }

            if (isset($attributes['percent_seller'])) {
                $percent_prevent = $attributes['percent_seller'];
            }

            $priceObj = new Price();
            //Se usa esto para convertir el precio dependiento el typo y como se va a guardar en la bd
            $price = $priceObj->priceConvert($priceType, $price);
            $percent_subdist = $priceObj->priceConvert($percentSubdistType, $percent_subdist);
            $percent_prevent = $priceObj->priceConvert($percentPreventType, $percent_prevent);

            $attributes['percent_prevent'] = $percent_prevent;
            $attributes['percent_subdist'] = $percent_subdist;
            $attributes['price'] = $price;

            // Elimino variables que no voy a usar para guardar el objeto
            unset($attributes['price_type']);
            unset($attributes['percent_subdist_type']);
            unset($attributes['percent_seller_type']);

            $attributesArrays[] = $attributes;
        }

        return $attributesArrays;
    }

    /**
     * @param $included
     *
     * @return bool
     * Se crean lo pricelist category que vienen de product en include
     */
    public function includedPricelistCategory($included)
    {

        $attributesArrays = [];
        foreach ($included as $var) {
            $attributes = $var;
            $priceType = 'auto';
            if (isset($attributes['price_type'])) {
                $priceType = $attributes['price_type'];
            }

            $percentSubdistType = 'auto';
            if (isset($attributes['percent_subdist_type'])) {
                $percentSubdistType = $attributes['percent_subdist_type'];
            }

            $percentPreventType = 'auto';
            if (isset($attributes['percent_seller_type'])) {
                $percentPreventType = $attributes['percent_seller_type'];
            }

            $price = 0;
            $percent_subdist = 0;
            $percent_prevent = 0;

            if (isset($attributes['price'])) {
                $price = $attributes['percent_price'];
            }

            if (isset($attributes['percent_subdist'])) {
                $percent_subdist = $attributes['percent_subdist'];
            }

            if (isset($attributes['percent_seller'])) {
                $percent_prevent = $attributes['percent_seller'];
            }

            $priceObj = new Price();
            //Se usa esto para convertir el precio dependiento el typo y como se va a guardar en la bd
            $price = $priceObj->priceConvert($priceType, $price);
            $percent_subdist = $priceObj->priceConvert($percentSubdistType, $percent_subdist);
            $percent_prevent = $priceObj->priceConvert($percentPreventType, $percent_prevent);

            $attributes['percent_prevent'] = $percent_prevent;
            $attributes['percent_subdist'] = $percent_subdist;
            $attributes['percent_price'] = $price;

            // Elimino variables que no voy a usar para guardar el objeto
            unset($attributes['price_type']);
            unset($attributes['percent_subdist_type']);
            unset($attributes['percent_seller_type']);

            $attributesArrays[] = $attributes;
        }

        return $attributesArrays;
    }

    private function excludeReplacementCostIfIsVariantCommon($attributes, $rulesAttributes)
    {
        if ($attributes['conduct'] == 'variant_common') {
            unset($rulesAttributes['replacement_cost']);
        }

        return $rulesAttributes;
    }
}
