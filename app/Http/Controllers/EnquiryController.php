<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\SiteEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enquiry_type' => 'required|in:callback,contact',
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:2000',
            'property_slug' => 'nullable|string|max:140',
        ]);

        $validator->after(function ($validator) use ($request): void {
            $digits = preg_replace('/\D+/', '', (string) $request->input('phone', ''));
            if (strlen((string) $digits) !== 10) {
                $validator->errors()->add('phone', 'Enter a valid 10-digit phone number.');
            }

            if ($request->input('enquiry_type') === SiteEnquiry::TYPE_CALLBACK) {
                $slug = trim((string) $request->input('property_slug', ''));
                if ($slug === '') {
                    $validator->errors()->add('property_slug', 'Property reference is missing for this request.');
                    return;
                }

                $exists = Property::query()->where('slug', $slug)->where('is_published', true)->exists();
                if (!$exists) {
                    $validator->errors()->add('property_slug', 'This property is not available for enquiries.');
                }
            }
        });

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->messages() as $field => $fieldErrors) {
                $errors[$field] = $fieldErrors[0] ?? '';
            }
            if (empty($errors)) {
                $errors['_error'] = 'Something went wrong. Please try again.';
            }

            return response()->json(['ok' => false, 'errors' => $errors], 400);
        }

        $digits = preg_replace('/\D+/', '', (string) $request->input('phone', ''));
        $propertyId = null;
        if ($request->input('enquiry_type') === SiteEnquiry::TYPE_CALLBACK) {
            $propertyId = Property::query()->where('slug', $request->input('property_slug'))->where('is_published', true)->value('id');
        }

        SiteEnquiry::query()->create([
            'enquiry_type' => $request->input('enquiry_type'),
            'name' => $request->input('name'),
            'phone' => $digits,
            'message' => (string) $request->input('message', ''),
            'property_id' => $propertyId,
        ]);

        return response()->json(['ok' => true]);
    }
}
