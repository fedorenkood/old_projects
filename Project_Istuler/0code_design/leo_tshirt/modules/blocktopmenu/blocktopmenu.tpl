{if $MENU != ''}
	<!-- Menu -->
	<div id="block_top_menu" class="sf-contener clearfix">
		<div class="cat-title"><i class="fa fa-navicon"></i></div>
		<ul class="sf-menu clearfix menu-content">
			{$MENU}			
		</ul>
		{if $MENU_SEARCH}
			<div class="sf-search noBack">
				<form id="searchbox" action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" method="get">
					<p>
						<input type="hidden" name="controller" value="search" />
						<input type="hidden" value="position" name="orderby"/>
						<input type="hidden" value="desc" name="orderway"/>
							<input type="text" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|escape:'html':'UTF-8'}{/if}" />
					</p>
					<span>
						<button class="btn btn-outline-inverse" name="submit_search" type="submit">
							<span class="button-search fa fa-search"></span>
						</button>
					</span>
				</form>
			</div>
		{/if}
	</div>	
	<!--/ Menu -->
{/if}