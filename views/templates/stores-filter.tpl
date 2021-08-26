<h3>Résultat de recherche</h3>
<div class="result">
    {foreach $stores as $store}
        <article id="store-{$store.id}" class="store-item card col-md-4">
            <div class="store-item-container clearfix">
                <div class="store-description">
                    <p class="h3 card-title">{$store.name}</p>
                    <p class="distance">{$store.distance} km</p>
                    <p class="hour">{$store.today_hours}</p>
                    <address>{$store.address.formatted nofilter}</address>
                    {if $store.note}
                        <p class="text-justify">{$store.note}</p>
                    {/if}
                    {if $store.phone}
                        <p><i class="material-icons">&#xE0B0;</i>{$store.phone}</p>
                    {/if}
                    {if $store.fax}
                        <p><i class="material-icons">&#xE8AD;</i>{$store.fax}</p>
                    {/if}
                    {if $store.email}
                        <p><i class="material-icons">&#xE0BE;</i>{$store.email}</p>
                    {/if}
                </div>
            </div>
        </article>
    {/foreach}
</div>
