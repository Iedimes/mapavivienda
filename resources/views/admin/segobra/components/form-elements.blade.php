@include('brackets/admin-ui::admin.includes.media-uploader', [
                    'mediaCollection' => app(App\Models\Segobra::class)->getMediaCollection('gallery'),
                    'label' => 'Fotografias',
                    'media' => $segobra->getThumbs200ForCollection('gallery'),])



