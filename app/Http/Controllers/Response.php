<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;

class Response
{
    public static function ok(bool $status,string $type,mixed $data,bool $export = false): HttpResponse
    {
        if($export)
            return response(['status' => $status,'excel' => route('excel.download'),'pdf' => route('pdf.download'),'type' => $type,'data' => $data], 200);
        return response(['status' => $status,'type' => $type,'data' => $data], 200);
    }

    public static function created(bool $status,string $type,mixed $data): HttpResponse
    {
        return response(['status' => $status,'type' => $type,'data' => $data], 201);
    }

    public static function deleted(bool $status,string $type): HttpResponse
    {
        return response(['status' => $status,'type' => $type,'message' => 'Successfully deleted'], 200);
    }

    public static function notFound(string $message = 'Item Not Found Maybe Resource Deleted'): HttpResponse
    {
        return response(['message' => $message], 404);
    }
}
