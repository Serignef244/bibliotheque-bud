<?php

namespace App\Http\Requests;

use App\Services\ProlongationService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProlongationRequest extends FormRequest
{
    public function __construct(
        private readonly ProlongationService $prolongationService,
    ) {}

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'pret_id' => 'required|exists:prets,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $pret = \App\Models\Pret::find($this->input('pret_id'));
            if ($pret) {
                $raisonsRefus = $this->prolongationService->getRaisonsRefus($pret);
                foreach ($raisonsRefus as $raison) {
                    $validator->errors()->add('pret_id', $raison);
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'pret_id.required' => 'Le prêt est requis',
            'pret_id.exists' => 'Le prêt n\'existe pas',
        ];
    }
}
