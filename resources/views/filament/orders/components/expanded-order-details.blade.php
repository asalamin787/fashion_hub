<div style="width:100%; display:flex; flex-direction:column; gap:24px;">

	{{-- ===== ORDER ITEMS ===== --}}
	<section style="display:flex; flex-direction:column; gap:10px;">
		<div style="padding:0 2px;">
			<span style="font-size:1rem; font-weight:700; color:#e2e8f0; letter-spacing:-0.01em;">Order Items</span>
			<p style="margin-top:3px; font-size:0.8rem; color:#94a3b8;">
				{{ $order->items->count() }} {{ \Illuminate\Support\Str::plural('Item', $order->items->count()) }} In This Order
			</p>
		</div>

		<div style="overflow-x:auto; border-radius:8px; border:1px solid rgba(255,255,255,0.10); overflow:hidden;">
			<table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
				<thead>
					<tr style="background:rgba(255,255,255,0.06);">
						<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Item Image</th>
						<th style="padding:11px 16px; text-align:left; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Item Name</th>
						<th style="padding:11px 16px; text-align:center; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Quantity</th>
						<th style="padding:11px 16px; text-align:right; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); border-right:1px solid rgba(255,255,255,0.06); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Unit Price</th>
						<th style="padding:11px 16px; text-align:right; font-size:0.78rem; font-weight:600; color:#e2e8f0; border-bottom:1px solid rgba(255,255,255,0.08); white-space:nowrap; text-transform:uppercase; letter-spacing:0.04em;">Total Price</th>
					</tr>
				</thead>
				<tbody>
					@forelse($order->items as $item)
						@php
							$imageUrl = $item->image
								? asset('storage/' . ltrim((string) $item->image, '/'))
								: 'https://placehold.co/64x64/334155/94a3b8?text=' . urlencode(substr((string) $item->product_name, 0, 1));

							$metaVariantLabel = data_get($item->meta, 'variant_label')
								?? data_get($item->meta, 'variant.label')
								?? data_get($item->meta, 'variant')
								?? null;

							$variantLabel = filled($item->variant_label)
								? (string) $item->variant_label
								: (filled($metaVariantLabel) ? (string) $metaVariantLabel : null);
						@endphp
						<tr style="background:transparent;">
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); vertical-align:middle;">
								<img
									src="{{ $imageUrl }}"
									alt="{{ $item->product_name }}"
									style="width:58px; height:58px; border-radius:7px; object-fit:cover; border:1px solid rgba(255,255,255,0.10); display:block;"
								>
							</td>
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); vertical-align:middle;">
								<div style="display:flex; flex-direction:column; gap:3px;">
									<span style="font-size:0.88rem; font-weight:500; color:#e2e8f0;">{{ $item->product_name }}</span>

									@if (filled($variantLabel))
										<span style="font-size:0.75rem; color:#e2e8f0;">Variant: {{ $variantLabel }}</span>
									@elseif (filled($item->product_variant_id))
										<span style="font-size:0.75rem; color:#e2e8f0;">Variant ID: {{ $item->product_variant_id }}</span>
									@endif

									@if (filled($item->sku))
										<span style="font-size:0.72rem; color:#e2e8f0;">SKU: {{ $item->sku }}</span>
									@endif
								</div>
							</td>
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); vertical-align:middle; text-align:center; font-size:0.88rem; color:#e2e8f0;">{{ $item->quantity }}</td>
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); border-right:1px solid rgba(255,255,255,0.06); vertical-align:middle; text-align:right; font-size:0.88rem; color:#e2e8f0;">${{ number_format((float) $item->unit_price, 2) }}</td>
							<td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); vertical-align:middle; text-align:right; font-size:0.88rem; font-weight:600; color:#f1f5f9;">${{ number_format((float) $item->line_total, 2) }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" style="padding:32px 16px; text-align:center; font-size:0.875rem; color:#64748b;">No items found for this order.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</section>

	{{-- ===== ORDER SUMMARY ===== --}}
	<section style="display:flex; flex-direction:column; gap:10px;">
		<span style="font-size:1rem; font-weight:700; color:#f1f5f9; letter-spacing:-0.01em; padding:0 2px;">Order Summary</span>
		@if ($order->first_order_discount_applied)
			<span style="margin:0 2px; display:inline-flex; width:max-content; padding:4px 10px; border-radius:999px; background:rgba(16,185,129,0.12); color:#6ee7b7; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em;">First Order Discount Applied</span>
		@endif

		<div style="border-radius:8px; border:1px solid rgba(255,255,255,0.10); overflow:hidden;">
			<table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
				<tbody>
					<tr style="background:rgba(255,255,255,0.03);">
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0; width:60%;">Subtotal</td>
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.86rem; color:#e2e8f0;">${{ number_format((float) $order->subtotal, 2) }}</td>
					</tr>
					<tr style="background:transparent;">
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Shipping</td>
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.86rem; color:#e2e8f0;">${{ number_format((float) $order->shipping_amount, 2) }}</td>
					</tr>
					<tr style="background:rgba(255,255,255,0.03);">
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">Tax</td>
						<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.86rem; color:#e2e8f0;">${{ number_format((float) $order->tax_amount, 2) }}</td>
					</tr>
					@if ((float) $order->coupon_discount_amount > 0)
						<tr style="background:transparent;">
							<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">
								Coupon Discount @if ($order->coupon_code)<span style="color:#86efac;">({{ $order->coupon_code }})</span>@endif
							</td>
							<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.86rem; color:#86efac;">-${{ number_format((float) $order->coupon_discount_amount, 2) }}</td>
						</tr>
					@endif
					@if ((float) $order->first_order_discount_amount > 0)
						<tr style="background:transparent;">
							<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); font-size:0.86rem; font-weight:500; color:#e2e8f0;">First Order Discount ({{ number_format((float) $order->first_order_discount_rate, 0) }}%)</td>
							<td style="padding:11px 16px; border-bottom:1px solid rgba(255,255,255,0.06); text-align:right; font-size:0.86rem; color:#86efac;">-${{ number_format((float) $order->first_order_discount_amount, 2) }}</td>
						</tr>
					@endif
					<tr style="background:rgba(255,255,255,0.05);">
						<td style="padding:13px 16px; font-size:0.9rem; font-weight:700; color:#e2e8f0;">Grand Total</td>
						<td style="padding:13px 16px; text-align:right; font-size:0.9rem; font-weight:700; color:#e2e8f0;">${{ number_format((float) $order->total_amount, 2) }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>

	{{-- ===== CUSTOMER NOTE ===== --}}
	@if($order->order_notes)
		<section style="border-radius:8px; border:1px solid rgba(251,191,36,0.25); background:rgba(251,191,36,0.07); padding:14px 18px;">
			<p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:#fbbf24;">Customer Note</p>
			<p style="margin-top:5px; font-size:0.875rem; color:#fde68a;">{{ $order->order_notes }}</p>
		</section>
	@endif

</div>
