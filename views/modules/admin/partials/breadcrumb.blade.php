{{--*/
    $linkData = \Modules\Admin\Services\Helper\MenuHelper::getRouteByPage();
    if(!empty($linkData['page_header'])){
        $menus = [
        ['label' => $linkData['category_name'], 'link' => 'javascript:;'],
        ['label' => $linkData['link_name'], 'link' => '']];
    }
/*--}}

@section('template-level-scripts')
@parent
<script>
    siteObjJs.admin.commonJs.constants.recordsPerPage = "{{--*/ echo $linkData['pagination'];/*--}}";
</script>
@stop

<div class="page-head">
    <div class="page-title">
        <h1>{!! $linkData['page_header'] !!}</h1>
        @if($linkData['page_text'])
        <h4>
            {!! $linkData['page_text'] !!}
        </h4>
        @endif

        <ul class="page-breadcrumb breadcrumb">
            <li>
                {!! link_to('/admin/dashboard', trans('admin::controller/user.admin')) !!}<i class="fa fa-circle"></i> 
            </li>

            @foreach($menus as $menu)
            <li>
                @if(!empty($menu['link']) && $menu['link']=='javascript:;' )
                <a href="javascript:;">{{ $menu['label'] }}</a>
                @else
                <span class="text-muted"> {{ $menu['label'] }}</span>
                @endif
                <i class="fa fa-circle"></i> 
            </li>
            @endforeach
        </ul>
    </div>
</div>