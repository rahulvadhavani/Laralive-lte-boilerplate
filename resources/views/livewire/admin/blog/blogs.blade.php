<div>
    @livewire('admin.breadcrumb',['page' => $page])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-3">
                        <div class="table-responsive">
                            <livewire:admin.blog.table />
                        </div>
                    </div>
                </div>
                @include('livewire.admin.blog.modals')
            </div>
        </div>
    </section>
</div>