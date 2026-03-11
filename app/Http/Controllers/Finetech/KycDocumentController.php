<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\KycDocument;
use App\Support\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycDocumentController extends Controller
{
    private array $rules = [
        'customer_id'     => 'required|exists:customers,id',
        'document_type'   => 'required|in:national_id,passport,driving_license,voter_id,aadhaar,pan_card',
        'document_number' => 'required|string|max:255',
        'front_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'back_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'expiry_date'     => 'nullable|date',
        'status'          => 'required|in:pending,verified,rejected',
        'remark'          => 'nullable|string|max:1000',
    ];

    public function index()
    {
        return view('finetech.kyc-documents.index', [
            'kycDocuments' => KycDocument::with('customer', 'reviewer')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.kyc-documents.create', [
            'customers' => Customer::where('status', 'active')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules, [
            'front_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]));

        try {
            $imageHandler = new ImageHandler('kyc-documents');

            $frontPath = $imageHandler->upload($request->file('front_image'));
            $backPath = null;
            if ($request->hasFile('back_image')) {
                $backPath = $imageHandler->upload($request->file('back_image'));
            }

            KycDocument::create([
                'customer_id'     => $request->customer_id,
                'document_type'   => $request->document_type,
                'document_number' => $request->document_number,
                'front_image'     => $frontPath,
                'back_image'      => $backPath,
                'expiry_date'     => $request->expiry_date,
                'status'          => $request->status,
                'remark'          => $request->remark,
                'reviewed_by'     => $request->status !== 'pending' ? Auth::id() : null,
                'reviewed_at'     => $request->status !== 'pending' ? now() : null,
            ]);

            toastr()->success('KYC Document created successfully.');
            return redirect()->route('finetech.kyc-documents.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(KycDocument $kycDocument)
    {
        $kycDocument->load('customer', 'reviewer');
        return view('finetech.kyc-documents.show', ['kycDocument' => $kycDocument]);
    }

    public function edit(KycDocument $kycDocument)
    {
        return view('finetech.kyc-documents.edit', [
            'kycDocument' => $kycDocument,
            'customers'   => Customer::where('status', 'active')->get(),
        ]);
    }

    public function update(Request $request, KycDocument $kycDocument)
    {
        $request->validate($this->rules);

        try {
            $imageHandler = new ImageHandler('kyc-documents');

            $frontPath = $kycDocument->front_image;
            if ($request->hasFile('front_image')) {
                if ($kycDocument->front_image) {
                    $imageHandler->delete($kycDocument->front_image);
                }
                $frontPath = $imageHandler->upload($request->file('front_image'));
            }

            $backPath = $kycDocument->back_image;
            if ($request->hasFile('back_image')) {
                if ($kycDocument->back_image) {
                    $imageHandler->delete($kycDocument->back_image);
                }
                $backPath = $imageHandler->upload($request->file('back_image'));
            }

            $reviewData = [];
            if ($request->status !== 'pending' && $kycDocument->status === 'pending') {
                $reviewData = [
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                ];
            }

            $kycDocument->update(array_merge([
                'customer_id'     => $request->customer_id,
                'document_type'   => $request->document_type,
                'document_number' => $request->document_number,
                'front_image'     => $frontPath,
                'back_image'      => $backPath,
                'expiry_date'     => $request->expiry_date,
                'status'          => $request->status,
                'remark'          => $request->remark,
            ], $reviewData));

            toastr()->success('KYC Document updated successfully.');
            return redirect()->route('finetech.kyc-documents.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(KycDocument $kycDocument)
    {
        try {
            $imageHandler = new ImageHandler('kyc-documents');
            if ($kycDocument->front_image) {
                $imageHandler->delete($kycDocument->front_image);
            }
            if ($kycDocument->back_image) {
                $imageHandler->delete($kycDocument->back_image);
            }
            $kycDocument->delete();
            toastr()->success('KYC Document deleted successfully.');
            return redirect()->route('finetech.kyc-documents.index');
        } catch (\Exception $e) {
            toastr()->error('Failed to delete KYC document. Please try again.');
            return redirect()->back();
        }
    }
}
