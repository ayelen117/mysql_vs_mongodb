<?php

namespace App\Http;

use App\Models\Mysql\Entity;

class InvoiceRequest extends BaseRequest
{
	
	/**
	 * @var array
	 */
	protected $ordersArray = [];
	
	/**
	 * @var array
	 */
	protected $invoicesArray = [];
	
	/**
	 * @var array
	 */
	protected $includeDetails = [];
	
	//Preparo la request, personalizo los datos
	public function prepare()
	{
		//Busco la relacion con entity
		try {
			$entity_id = $this->getRelationAttributeId('entities');
		} catch (\Exception $e) {
			$entity_id = 0;
		}
		
		//Busco la relacion con fiscal pos, que puede ser que no venga
		$fiscalpos_id = $this->getPossiblyRelationId('fiscalpos');
		$includeParam = $this->getIncludeParam();
		
		//Busco los quotatiosn relacionados en la peticion
		$this->invoicesArray = $this->getRelation('invoices');
		$this->ordersArray = $this->getRelation('orders');
		$this->includeDetails = $this->getInclude('details');
		
		$entityObject = Entity::find($entity_id);
		//Busco el seller segunn la entidad
		$seller_id = 0;
		if ($entityObject) {
			$sellers = $entityObject->parents;
			if (!$sellers->isEmpty()) {
				$seller_id = $sellers->first()->id;
			}
		}
		//Agrego los id a los atritutos, de esta request que se setean manualmente
		$defaultValues = [
			'currency_id' => 1,
			'seller_id' => $seller_id,
			'author_id' => $this->user_id,
			'entity_id' => $entity_id,
			'company_id' => $this->company_id,
			'fiscalpos_id' => $fiscalpos_id,
		];
		
		//Seteo los valores por defecto que voy a validar luego
		$this->setDefaultValues($defaultValues);
		
		$attributesArray = $this->getValidateAttributes('invoices');
		$attributesArray = $this->generateOrderAttribute($attributesArray);
		
		//Invoice type, puede ser (simple,details,orders)
		$invoice_type = $this->invoiceType();
		
		//Si vienen detalles, tengo que validarlos y hacer el parseo de tails
		if ($invoice_type == 'details') {
			$this->includeDetails = $this->getValidateInclude('details');
		}
		
		//Envio lo necesario
		$prepareArray = [
			'attributesArray' => $attributesArray,
			'detailsArray' => $this->includeDetails,
			'include' => $includeParam,
			'ordersArray' => $this->ordersArray,
			'invoicesArray' => $this->invoicesArray,
			'invoiceType' => $invoice_type,
		];
		
		$this['prepare'] = $prepareArray;
		
		if ($entity_id == 0 && $invoice_type != 'multiples') {
			throw  new  \Exception('No se envió la entidad.');
		}
		
		return $prepareArray;
	}
	
	/*
	 * Para saber el tipo de invoice, ya que pueden ser de 3 tipos (order,details,simple)
	 */
	private function invoiceType()
	{
		$method = strtolower($this->method());
		//Si es put o patch solamente pueden venir 2 tipos de factura
		//Con detalle o sin detalle
		$invoiceType = null;
		if (in_array($method, ['put', 'patch'])) {
			//Si vienen incluidos detalles, es del tipo detalles sino del tipo simple
			if (count($this->includeDetails) > 0) {
				$invoiceType = 'details';
			} else {
				$invoiceType = 'simple';
			}
			
			//Si es post solamente pueden venir 3 tipos de factura
			//Con detalle o sin detalle y de multiples remitos
		} else {
			if (count($this->ordersArray) > 0) {
				if ($this->defaultValues['entity_id'] == 0) {
					$invoiceType = 'multiples';
				} else {
					$invoiceType = 'orders';
				}
			} elseif (count($this->invoicesArray) > 0) {
				$invoiceType = 'credit';
			} elseif (count($this->includeDetails) > 0) {
				$invoiceType = 'details';
			} else {
				$invoiceType = 'simple';
			}
		}
		
		return $invoiceType;
	}
	
	/*
	 * Asigno el parametro generate order a los atributos de order
	 */
	private function generateOrderAttribute($attributesArray)
	{
		
		//El parametro order_confirm puede llegar
		$generate_order = true;
		if (isset($attributesArray['generate_order'])) {
			$generate_order = $attributesArray['generate_order'];
			
			if ($generate_order == 'true') {
				$generate_order = true;
			} elseif ($generate_order == true) {
				$generate_order = true;
			} elseif ($generate_order == 'false') {
				$generate_order = false;
			} elseif ($generate_order == false) {
				$generate_order = false;
			} else {
				$generate_order = true;
			}
		}
		$attributesArray['generate_order'] = $generate_order;
		
		return $attributesArray;
	}
}
