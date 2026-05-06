<div style="width:100%; display:flex; flex-direction:column; gap:24px;">

	{{-- ===== PRODUCT OVERVIEW ===== --}}
	<section style="display:flex; flex-direction:column; gap:10px;">
		<div style="padding:0 2px;">
			<span style="font-size:1rem; font-weight:700; color:#e2e8f0; letter-spacing:-0.01em;">Product Overview</span>
			<p style="margin-top:3px; font-size:0.8rem; color:#94a3b8;">
				Basic product information and status
			</p>
		</div>

		<div style="overflow-x:auto; border-radius:8px; border:1px solid rgba(255,255,255,0.10); overflow:hidden;">
			<table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
				<tbody>
					<tr style="background:rgba(255,255,255,0.03);">
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0; width:35%;">Featured Image</td>
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06);">
							@if($product->featured_image)
								<img src="{{ Storage::disk('public')->url($product->featured_image) }}" alt="{{ $product->name }}" style="width:80px; height:80px; border-radius:6px; object-fit:cover; border:1px solid rgba(255,255,255,0.10);">
							@else
								<span style="font-size:0.8rem; color:#64748b;">No image</span>
							@endif
						</td>
					</tr>
					<tr style="background:transparent;">
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Product Name</td>
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.88rem; font-weight:600; color:#f1f5f9;">{{ $product->name }}</td>
					</tr>
					<tr style="background:rgba(255,255,255,0.03);">
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Slug</td>
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.8rem; color:#cbd5e1; font-family:monospace;">{{ $product->slug }}</td>
					</tr>
					<tr style="background:transparent;">
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Status</td>
						<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06);">
							<span style="display:inline-block; padding:4px 12px; border-radius:6px; font-size:0.75rem; font-weight:600;
								@switch($product->status)
									@case('active')
										background:rgba(34,197,94,0.15); color:#86efac;
										@break
									@case('inactive')
										background:rgba(239,68,68,0.15); color:#fca5a5;
										@break
									@default
										background:rgba(251,146,60,0.15); color:#fed7aa;
								@endswitch
							">{{ ucfirst($product->status) }}</span>
						</td>
					</tr>
					@if($product->brand)
						<tr style="background:rgba(255,255,255,0.03);">
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Brand</td>
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.88rem; color:#e2e8f0;">{{ $product->brand->name }}</td>
						</tr>
					@endif
					@if($product->category)
						<tr style="background:transparent;">
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Category</td>
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.88rem; color:#e2e8f0;">{{ $product->category->name }}</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</section>

	{{-- ===== PRICING & INVENTORY ===== --}}
	<section style="display:flex; flex-direction:column; gap:10px;">
		<span style="font-size:1rem; font-weight:700; color:#f1f5f9; letter-spacing:-0.01em; padding:0 2px;">Pricing & Inventory</span>

		<div style="border-radius:8px; border:1px solid rgba(255,255,255,0.10); overflow:hidden;">
			<table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
				<tbody>
					@php
						$range = $product->price_range;
						$priceRange = 'Not set';
						if (is_array($range)) {
							$min = number_format((float) $range['min'], 2);
							$max = number_format((float) $range['max'], 2);
							$priceRange = $min === $max ? $min : $min.' - '.$max;
						}
					@endphp
					<tr style="background:rgba(255,255,255,0.03);">
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0; width:50%;">Price Range</td>
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.88rem; font-weight:600; color:#f1f5f9;">${{ $priceRange }}</td>
					</tr>
					<tr style="background:transparent;">
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Stock @if($product->has_variants)<span style="font-size:0.75rem; color:#94a3b8;">(Base/Variants)</span>@endif</td>
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.88rem; color:#e2e8f0;">
							@if($product->has_variants)
								<span style="color:#94a3b8;">See variants below</span>
							@else
								<span style="font-weight:600; color:#f1f5f9;">{{ $product->stock }}</span>
							@endif
						</td>
					</tr>
					<tr style="background:rgba(255,255,255,0.03);">
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Has Variants</td>
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.88rem; color:#e2e8f0;">
							@if($product->has_variants)
								<span style="color:#86efac;">Yes ({{ count($product->variants ?? []) }})</span>
							@else
								<span style="color:#cbd5e1;">No</span>
							@endif
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>

	{{-- ===== DESCRIPTIONS ===== --}}
	@if($product->short_description || $product->description)
		<section style="display:flex; flex-direction:column; gap:10px;">
			<span style="font-size:1rem; font-weight:700; color:#f1f5f9; letter-spacing:-0.01em; padding:0 2px;">Descriptions</span>

			<div style="border-radius:8px; border:1px solid rgba(255,255,255,0.10); padding:18px 20px;">
				@if($product->short_description)
					<div style="margin-bottom:14px;">
						<p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:#94a3b8; margin-bottom:6px;">Short Description</p>
						<p style="font-size:0.88rem; color:#e2e8f0;">{{ $product->short_description }}</p>
					</div>
				@endif

				@if($product->description)
					<div>
						<p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:#94a3b8; margin-bottom:6px;">Description</p>
						<div style="font-size:0.88rem; color:#e2e8f0; line-height:1.5;">
							{!! $product->description !!}
						</div>
					</div>
				@endif
			</div>
		</section>
	@endif

	{{-- ===== ATTRIBUTES ===== --}}
	@if(count($product->attribute_display_rows ?? []) > 0)
		<section style="display:flex; flex-direction:column; gap:10px;">
			<span style="font-size:1rem; font-weight:700; color:#f1f5f9; letter-spacing:-0.01em; padding:0 2px;">Product Attributes</span>

			<div style="border-radius:8px; border:1px solid rgba(255,255,255,0.10); overflow:hidden;">
				<table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
					<thead>
						<tr style="background:rgba(255,255,255,0.06);">
							<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); text-transform:uppercase; letter-spacing:0.04em;">Attribute</th>
							<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); text-transform:uppercase; letter-spacing:0.04em;">Type</th>
							<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); text-transform:uppercase; letter-spacing:0.04em;">Values</th>
						</tr>
					</thead>
					<tbody>
						@foreach($product->attribute_display_rows as $attr)
							<tr style="background:transparent;">
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.88rem; font-weight:500; color:#e2e8f0;">{{ $attr['name'] }}</td>
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.8rem; color:#cbd5e1;">
									<span style="display:inline-block; padding:3px 10px; border-radius:4px; background:rgba(148,163,184,0.15); color:#cbd5e1;">{{ $attr['display_type'] }}</span>
								</td>
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.8rem; color:#cbd5e1;">{{ $attr['values_label'] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	@endif

	{{-- ===== VARIANTS ===== --}}
	@if(count($product->variant_display_rows ?? []) > 0)
		<section style="display:flex; flex-direction:column; gap:10px;">
			<div style="padding:0 2px;">
				<span style="font-size:1rem; font-weight:700; color:#e2e8f0; letter-spacing:-0.01em;">Product Variants</span>
				<p style="margin-top:3px; font-size:0.8rem; color:#94a3b8;">
					{{ count($product->variant_display_rows ?? []) }} {{ \Illuminate\Support\Str::plural('Variant', count($product->variant_display_rows ?? [])) }}
				</p>
			</div>

			<div style="overflow-x:auto; border-radius:8px; border:1px solid rgba(255,255,255,0.10); overflow:hidden;">
				<table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
					<thead>
						<tr style="background:rgba(255,255,255,0.06);">
							<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Combination</th>
							<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">SKU</th>
							<th style="padding:11px 16px; text-align:right; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Price</th>
							<th style="padding:11px 16px; text-align:center; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Stock</th>
							<th style="padding:11px 16px; text-align:center; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($product->variant_display_rows as $variant)
							<tr style="background:transparent;">
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.88rem; color:#e2e8f0;">{{ $variant['combination_label'] }}</td>
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); font-size:0.8rem; color:#cbd5e1; font-family:monospace;">{{ $variant['sku'] }}</td>
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.88rem; font-weight:600; color:#f1f5f9;">${{ number_format((float) $variant['price'], 2) }}</td>
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); text-align:center; font-size:0.88rem; color:#e2e8f0;">{{ $variant['stock'] }}</td>
								<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:center;">
									<span style="display:inline-block; padding:4px 10px; border-radius:4px; font-size:0.75rem; font-weight:600;
										@if($variant['status'] === 'active')
											background:rgba(34,197,94,0.15); color:#86efac;
										@else
											background:rgba(148,163,184,0.15); color:#cbd5e1;
										@endif
									">{{ ucfirst($variant['status']) }}</span>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	@endif

	{{-- ===== TIMESTAMPS ===== --}}
	<div style="padding:0 2px; font-size:0.75rem; color:#64748b;">
		<p>Last updated: {{ $product->updated_at?->format('d M Y, h:i A') ?? '-' }}</p>
	</div>

</div>
