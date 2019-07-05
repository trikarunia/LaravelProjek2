<?php

namespace App\Observers;

use App\Invoice_detail;
use App\Invoice;

class Invoice_detailObserver
{
    private function generateTotal($invoiceDetail)
    {
        $invoice_id = $invoiceDetail->invoice_id;
        $invoice_detail = Invoice_detail::where('invoice_id', $invoice_id)->get();
        $total = $invoice_detail->sum(function($i) {
            return $i->price * $i->qty;
        });
        $invoiceDetail->invoice()->update([
            'total' => $total
        ]);
    }

    public function created(Invoice_detail $invoiceDetail)
    {
        $this->generateTotal($invoiceDetail);
    }

    public function updated(Invoice_detail $invoiceDetail)
    {
        $this->generateTotal($invoiceDetail);
    }

    public function deleted(Invoice_detail $invoiceDetail)
    {
        $this->generateTotal($invoiceDetail);
    }

    public function restored(Invoice_detail $invoiceDetail)
    {
        //
    }

    /**
     * Handle the invoice_detail "force deleted" event.
     *
     * @param  \App\Invoice_detail  $invoiceDetail
     * @return void
     */
    public function forceDeleted(Invoice_detail $invoiceDetail)
    {
        //
    }
}
