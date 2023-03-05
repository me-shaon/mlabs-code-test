<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use App\Transformers\AbstractWeatherTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected AbstractWeatherTransformer $weatherTransformer;

    public function __construct(User $user)
    {
        parent::__construct($user);


    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $weatherData = null;
        if ($this->weather) {
            $weatherTransformer = resolve(AbstractWeatherTransformer::class, ['weather' => $this->weather]);
            $weatherData = [
                'summary' => $weatherTransformer->getSummary(),
                'details' => $weatherTransformer->getDetails()
            ];
        }

        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'weather' => $weatherData
        ];
    }
}
