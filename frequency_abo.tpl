
<label>Frequency:</label>
<select name="subscription_frequency">
{foreach from=$frequencies item=row}
<option value="{$row.frequency}" data-coupon="{$row.coupon}">{$row.frequency}</option>
{/foreach}
</select>