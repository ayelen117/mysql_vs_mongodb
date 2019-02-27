<?php

namespace App\Http\Commands;



/**
 * Class InvoiceHandler
 *
 * @package amedidav6\Modules\InvoiceModule\Commands
 */
class InvoiceHandler
{
    use DispatchesJobs;

    /**
     * @param $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        $document = $command->document;
        $fiscalpos = $command->fiscalpos;

        if ($document instanceof Collection) {
            foreach ($document as $doc) {
                $this->sendDocument($doc, $fiscalpos);
            }
        } else {
            $this->sendDocument($document, $fiscalpos);
        }

        return $command;
    }

    public function sendDocument($document, $fiscalpos)
    {
        //Si es del tipo invoice que es el que soportamos hasta ahora y del tipo venta va a la impresoara fiscal o
        // factura electronica
        if ($document->section == 'sales') {
            if ($document->status == 'queued') {
                if ($fiscalpos) {
                    if ($fiscalpos->pos_type == 'electronic') {
                        if (env('APP_ENV') == 'develop') {
                            $document->confirmElectronicInvoice();
                        } else {
                            $this->dispatch(new ElectronicInvoiceJob($document));
                        }
                    }
                }
            }
        }
    }
}
