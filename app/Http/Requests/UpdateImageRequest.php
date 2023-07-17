<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property int parent_category_id
 */
class UpdateImageRequest extends CreateImageRequest
{

}
