<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

use Brackets\Media\HasMedia\HasMediaThumbsTrait;

class Segobra extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $table = 'SEGOBRA';

    protected $primaryKey = 'SEOBId';

    protected $fillable = [
        'SEOBId',
        'SEOBEmpr',
        'SEOBViv',
        'SEOBNCont',
        'SEOBProgr',
        'SEOBProy',
        'SEOBFisc',
        'SEOBSuper',
        'SEOBFecCo',
        'SEOBFecAn',

    ];


    protected $dates = [
        'SEOBFecCo',
        'SEOBFecAn',

    ];
    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function distrito() {
        return $this->hasOne('App\Distrito','CiuId','CiuId');
    }

    public function departamento() {
        return $this->hasOne('App\Departamento','DptoId','DptoId');
    }

    public function programa() {
        return $this->hasOne('App\Programa','value','SEOBProgr');
    }

    public function estado() {
        return $this->hasOne('App\Estado','value','SEOBEst');
    }

    public function terreno() {
        return $this->hasOne('App\Terreno','ident','SEOBTerr');
    }

    public function getResourceUrlAttribute()
    {
        return url('/admin/segobras/'.$this->getKey());
    }

    public function registerMediaCollections() {
        $this->addMediaCollection('gallery')
        ->maxNumberOfFiles(3) // Set the file count limit
        ->maxFilesize(10*1024*1024) // Set the file size limit
        ->accepts('image/*');
        //->accepts('application/pdf'); // Set the accepted file types (in MIME type format)
        //->canView('media.view') // Set the ability (Gate) which is required to view the medium (in most cases you would want to call private())
        //->canUpload('media.upload');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->autoRegisterThumb200();
    }
}
