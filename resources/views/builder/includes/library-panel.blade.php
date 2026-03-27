<?php
/**
 * Charms are grouped by their `group` column (plain string, e.g. "Hello Kitty", "BTS").
 * Previously this was driven by element_series FK — now it's just a direct string field.
 *
 * $elements is injected by the controller as a collection/array of all active elements.
 */
$charmGroups = collect($elements['charms'] ?? [])
    ->groupBy('group');

$figureGroups = collect($elements['figures'] ?? [])->groupBy('group');
?>

<div class="rpanel">
  <div class="rhead">Element Library</div>

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

  <!-- ══════════════════════════════════════
       BEADS TAB
  ══════════════════════════════════════ -->
  <div id="tab-beads" style="display:flex;flex-direction:column;flex:1;overflow-y:auto;overflow-x:hidden;min-height:0;">
    <div class="bead-groups" id="bead-groups"></div>
  </div>

  <!-- ══════════════════════════════════════
       FIGURES TAB
  ══════════════════════════════════════ -->
  <div id="tab-figures" style="display:none;flex-direction:column;flex:1;overflow-y:auto;overflow-x:hidden;min-height:0;">
    <div class="lsrch" style="position:sticky;top:0;z-index:2;">
      <input type="text" placeholder="Search figures…" oninput="app.ui.filterCharms(this, 'grid-figures')"/>
    </div>
    <div class="lgrid" id="grid-figures" style="overflow-y:auto;overflow-x:hidden;flex:1;min-height:0;"></div>
  </div>

  <!-- ══════════════════════════════════════
       CHARMS TAB
       Uses .bgroup / .bgroup-* for the
       collapsible group headers (same
       pattern as bead groups) and
       .lgrid + .ecard for the item tiles.
  ══════════════════════════════════════ -->
  <div id="tab-charms" style="display:none;flex-direction:column;flex:1;overflow-y:auto;overflow-x:hidden;min-height:0;">

    <div class="lsrch" style="position:sticky;top:0;z-index:2;">
      <input type="text"
             placeholder="Search charms…"
             oninput="app.ui.filterCharms(this, 'charms-groups-wrap')"/>
    </div>

    <div id="charms-groups-wrap" style="overflow-y:auto;overflow-x:hidden;flex:1;min-height:0;padding:7px 8px;display:flex;flex-direction:column;gap:5px;background:var(--white);">

      @forelse ($charmGroups as $groupName => $charms)

        {{-- Collapsible group — reuses the .bgroup structure from the stylesheet --}}
        <div class="bgroup open" data-group="{{ Str::slug($groupName) }}">

          {{-- Group header --}}
          <div class="bgroup-head" onclick="this.closest('.bgroup').classList.toggle('open')">
            <div class="bgroup-head-l">
              <span class="bgroup-lbl">{{ $groupName }}</span>
            </div>
            <div class="bgroup-head-r">
              {{-- item count badge --}}
              <span class="sbd s-in">{{ $charms->count() }}</span>
              <svg class="bgroup-arr" viewBox="0 0 12 12">
                <polyline points="2,4 6,8 10,4"/>
              </svg>
            </div>
          </div>

          {{-- Charm grid for this group — max-height keeps each group independently scrollable --}}
          <div class="bgroup-body" style="padding:8px;max-height:220px;overflow-y:auto;overflow-x:hidden;">
            <div class="lgrid"
                 style="grid-template-columns:1fr 1fr;gap:7px;padding:0;overflow:visible;">

              @foreach ($charms as $charm)

                <div class="ecard figure
                            {{ $charm['stock'] === 'out' ? 'out' : '' }}"
                     data-slug="{{ $charm['slug'] }}"
                     data-search="{{ strtolower($charm['name'] . ' ' . $groupName) }}"
                     onclick="{{ $charm['stock'] !== 'out' ? "app.ui.addElement('" . $charm['slug'] . "')" : '' }}"
                     title="{{ $charm['name'] }}{{ $charm['stock'] === 'low' ? ' — Low Stock' : '' }}{{ $charm['stock'] === 'out' ? ' — Out of Stock' : '' }}">

                  {{-- Thumbnail --}}
                  <div class="eprev-img">
                    @if ($charm['use_img'] && $charm['img_path'])
                      <img src="{{ asset('img/builder/' . $charm['img_path']) }}"
                           alt="{{ $charm['name'] }}"
                           loading="lazy"/>
                    @else
                      {{-- Fallback initial placeholder --}}
                      <div style="
                        width:52px;height:52px;border-radius:var(--r-sm);
                        background:var(--pink-lt);border:1.5px solid var(--pink-bd);
                        display:flex;align-items:center;justify-content:center;
                        font-family:var(--fh);font-size:1.1rem;font-weight:800;
                        color:var(--pink-dk);">
                        {{ strtoupper(substr($charm['name'], 0, 1)) }}
                      </div>
                    @endif
                  </div>

                  {{-- Name --}}
                  <div class="ename">{{ $charm['name'] }}</div>

                  {{-- Price --}}
                  <div style="font-size:.6rem;font-weight:800;color:var(--pink);">
                    ₱{{ $charm['price'] }}
                  </div>

                  {{-- Stock badge --}}
                  @if ($charm['stock'] === 'low')
                    <span class="sbd s-low">Low</span>
                  @elseif ($charm['stock'] === 'out')
                    <span class="sbd s-out">Out</span>
                  @endif

                </div>

              @endforeach

            </div>{{-- /.lgrid --}}
          </div>{{-- /.bgroup-body --}}

        </div>{{-- /.bgroup --}}

      @empty

        <div class="dempty">
          <div class="dempty-icon">✽</div>
          No charms available.
        </div>

      @endforelse

    </div>{{-- /#charms-groups-wrap --}}
  </div>{{-- /#tab-charms --}}

  <!-- ══════════════════════════════════════
       LETTERS TAB
  ══════════════════════════════════════ -->
  <div id="tab-letters" style="display:none;flex-direction:column;flex:1;overflow-y:auto;overflow-x:hidden;min-height:0;">
    <div class="lshape-row" style="position:sticky;top:0;z-index:2;">
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
    <div class="lclr" style="position:sticky;top:38px;z-index:2;">
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
    <div class="lgrid-ltrs" id="grid-ltrs" style="overflow-y:auto;overflow-x:hidden;flex:1;min-height:0;"></div>
  </div>

</div>{{-- /.rpanel --}}