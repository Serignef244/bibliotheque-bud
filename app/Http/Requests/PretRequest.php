<?php

namespace App\Http\Requests;

use App\Services\VerificationService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PretRequest extends FormRequest
{
    public function __construct(
        private readonly VerificationService $verificationService,
    ) {}

    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bibliothecaire'));
    }

    public function rules(): array
    {
        return [
            'adherent_id' => 'required|exists:adherents,id',
            'exemplaire_id' => 'required|exists:exemplaires,id',
            'date_emprunt' => 'required|date',
            'remarques' => 'nullable|string|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $adherentId = $this->input('adherent_id');
            $exemplaireId = $this->input('exemplaire_id');

            if (!empty($adherentId)) {
                $errors = $this->verificationService->getVerificationErrors((int) $adherentId);
                foreach ($errors as $error) {
                    $validator->errors()->add('adherent_id', $error);
                }
            }

            if (!empty($exemplaireId) && !$this->verificationService->isExemplaireDisponible((int) $exemplaireId)) {
                $validator->errors()->add('exemplaire_id', 'Cet exemplaire n\'est pas disponible');
            }
        });
    }

    public function messages(): array
    {
        return [
            'adherent_id.required' => 'L\'adhérent est requis',
            'adherent_id.exists' => 'L\'adhérent n\'existe pas',
            'exemplaire_id.required' => 'L\'exemplaire est requis',
            'exemplaire_id.exists' => 'L\'exemplaire n\'existe pas',
            'date_emprunt.required' => 'La date d\'emprunt est requise',
            'date_emprunt.date' => 'La date d\'emprunt doit être une date valide',
        ];
    }
}
