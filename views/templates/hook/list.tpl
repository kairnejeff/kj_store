
<div class="panel"><h3><i class="icon-list-ul"></i> {l s='list of group' d='Modules.Imageslider.Admin'}
	<span class="panel-heading-action">
		<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure=kj_store&addGroup=1">
			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add new' d='Admin.Actions'}" data-html="true">
				<i class="process-icon-new "></i>
			</span>
		</a>
	</span>
	</h3>
	<div id="slidesContent">
		<div id="slides">
			{foreach from=$groups item=group}
				<div id="slides_{$group.id_group_store}" class="panel">
					<div class="row">
						<div class="col-md-6">
							<h3>{$group.name}</h3>
						</div>
						<div class="col-md-6">
							<div class="btn-group-action pull-right">
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=kj_store&id_group={$group.id_group_store}">
									<i class="icon-edit"></i>
									{l s='Edit' d='Admin.Actions'}
								</a>
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=kj_store&delete_id_group={$group.id_group_store}">
									<i class="icon-trash"></i>
									{l s='Delete' d='Admin.Actions'}
								</a>
							</div>
						</div>
					</div>
				</div>
			{/foreach}
		</div>
	</div>
</div>
