<?php
/**
 * Charms are grouped by their `group` column (plain string, e.g. "Hello Kitty", "BTS").
 * Previously this was driven by element_series FK — now it's just a direct string field.
 *
 * $elements is injected by the controller as a collection/array of all active elements.
 */
$charmGroups = collect($elements ?? [])
    ->where('category', 'charms')
    ->groupBy('group');          // group is now a plain string, no FK needed
?>
<div class="rpanel">
  <div class="rhead">Element Library </div>

  <div class="dir-toggle">
    <span class="dir-lbl">Insert At:</span>
    <div class="dir-btns">
      <button class="dir-btn" onclick="app.ui.setAddDir('left', this)">← Left</button>
      <button class="dir-btn active" onclick="app.ui.setAddDir('right', this)">Right →</button>
    </div>
  </div>

  <div class="ltabs" id="lib-tabs">
    <div class="ltab active" data-tab="beads"   onclick="app.ui.switchTab(this)">Beads</div>
    <div class="ltab"        data-tab="figures" onclick="app.ui.switchTab(this)">Figures</div>
    <div class="ltab"        data-tab="charms"  onclick="app.ui.switchTab(this)">Charms</div>
    <div class="ltab"        data-tab="letters" onclick="app.ui.switchTab(this)">A–Z</div>
  </div>

  <!-- Beads tab -->
  <div id="tab-beads" style="display:flex;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
    <div class="bead-groups" id="bead-groups"></div>
  </div>

  <!-- Figures tab — shaped decorative charms (hearts, stars, bows, etc.) -->
  <div id="tab-figures" style="display:none;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
    <div class="lsrch">
      <input type="text" placeholder="Search figures..." oninput="app.ui.filterCharms(this, 'grid-figures')"/>
    </div>
    <div class="lgrid" id="grid-figures" style="overflow-y:auto;overflow-x:hidden;flex:1;min-height:0;"></div>
  </div>

  <!-- Charms tab — image-based groups (Hello Kitty, BTS, etc.) grouped by `group` field -->
  <div id="tab-charms" style="display:none;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
    <div class="lsrch">
      <input type="text" placeholder="Search charms..." oninput="app.ui.filterCharms(this, 'charms-groups-wrap')"/>
    </div>

    <div id="charms-groups-wrap" style="overflow-y:auto;flex:1;min-height:0;padding:8px 0;">

      @forelse ($charmGroups as $groupName => $charms)
        <div class="charm-group" data-group="{{ $groupName }}">

          <!-- Group header -->
          <div class="charm-group-hd">
            <span class="charm-group-label">{{ $groupName }}</span>
            <span class="charm-group-count">{{ $charms->count() }}</span>
          </div>

          <!-- Charm grid for this group -->
          <div class="lgrid charm-group-grid">
            @foreach ($charms as $charm)
              <div class="litem charm-litem
                          {{ $charm['stock'] === 'out'  ? 'litem-out'  : '' }}
                          {{ $charm['stock'] === 'low'  ? 'litem-low'  : '' }}
                          {{ $charm['is_large']         ? 'litem-large': '' }}"
                   data-slug="{{ $charm['slug'] }}"
                   data-name="{{ $charm['name'] }}"
                   data-search="{{ strtolower($charm['name'] . ' ' . $groupName) }}"
                   onclick="{{ $charm['stock'] !== 'out' ? 'app.ui.addElement(\'' . $charm['slug'] . '\')' : '' }}"
                   title="{{ $charm['name'] }}{{ $charm['stock'] === 'low' ? ' — Low Stock' : '' }}{{ $charm['stock'] === 'out' ? ' — Out of Stock' : '' }}">

                @if ($charm['use_img'] && $charm['img_path'])
                  <img src="{{ asset('img/builder/' . $charm['img_path']) }}"
                       alt="{{ $charm['name'] }}"
                       class="charm-img"
                       loading="lazy"/>
                @else
                  <div class="charm-placeholder">{{ substr($charm['name'], 0, 1) }}</div>
                @endif

                @if ($charm['stock'] === 'low')
                  <span class="stock-pip low">!</span>
                @elseif ($charm['stock'] === 'out')
                  <span class="stock-pip out">✕</span>
                @endif

                <div class="litem-lbl">{{ $charm['name'] }}</div>
                <div class="litem-price">₱{{ $charm['price'] }}</div>
              </div>
            @endforeach
          </div>

        </div>
      @empty
        <div class="dempty" style="padding:24px;text-align:center;color:var(--grey-400);">
          <div class="dempty-icon">✽</div>
          No charms available.
        </div>
      @endforelse

    </div>
  </div>

  <!-- Letters tab -->
  <div id="tab-letters" style="display:none;flex-direction:column;flex:1;overflow:hidden;min-height:0;">
    <div class="lshape-row">
      <span class="dir-lbl">Tile Shape:</span>
      <div class="lshape-btns">
        <button class="lshape-btn active" onclick="app.ui.setLetterShape('square', this)">
          <span class="lshape-preview lshape-sq">A</span> Square
        </button>
        <button class="lshape-btn" onclick="app.ui.setLetterShape('round', this)">
          <span class="lshape-preview lshape-rd">A</span> Circle
        </button>
      </div>
    </div>
    <div class="lclr">
      <div class="slbl" style="margin:0;font-size:.65rem;white-space:nowrap;">Color</div>
      <div class="swatches" id="ltr-sw">
        <div class="sw active" style="background:#fff;"    onclick="app.ui.setLtrCol('#ffffff','#333344',this)"></div>
        <div class="sw"        style="background:#F9B8CF;" onclick="app.ui.setLtrCol('#F9B8CF','#ffffff',this)"></div>
        <div class="sw"        style="background:#90DDD9;" onclick="app.ui.setLtrCol('#90DDD9','#ffffff',this)"></div>
        <div class="sw"        style="background:#C9A9F0;" onclick="app.ui.setLtrCol('#C9A9F0','#ffffff',this)"></div>
        <div class="sw"        style="background:#CCE86A;" onclick="app.ui.setLtrCol('#CCE86A','#ffffff',this)"></div>
        <div class="sw"        style="background:#FFE07A;" onclick="app.ui.setLtrCol('#FFE07A','#ffffff',this)"></div>
        <div class="sw"        style="background:#3D3D52;" onclick="app.ui.setLtrCol('#3D3D52','#ffffff',this)"></div>
      </div>
    </div>
    <div class="lgrid-ltrs" id="grid-ltrs"></div>
  </div>
</div>