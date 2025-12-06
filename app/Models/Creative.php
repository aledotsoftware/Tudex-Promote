<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'title',
        'description',
        'button_text',
        'image_url',
        'click_url',
        'is_active',
        'bg_color',
        'title_color',
        'text_color',
        'button_color',
        'border_color',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Generate HTML for a specific format
     * 
     * @param string $format The format type: wide, tall, square, popup, native
     * @param string|null $clickUrl Override click URL (for tracking)
     * @return string Generated HTML
     */
    public function generateHtml(string $format = 'wide', ?string $clickUrl = null): string
    {
        $url = $clickUrl ?? $this->click_url;
        $domain = parse_url($this->click_url, PHP_URL_HOST) ?? 'promoted';
        
        // Get colors with defaults
        $bgColor = $this->bg_color ?? '#ffffff';
        $titleColor = $this->title_color ?? '#0f172a';
        $textColor = $this->text_color ?? '#64748b';
        $buttonColor = $this->button_color ?? '#3b82f6';
        $borderColor = $this->border_color ?? '#e2e8f0';
        
        // Escape content
        $title = htmlspecialchars($this->title ?? '');
        $description = htmlspecialchars($this->description ?? '');
        $buttonText = htmlspecialchars($this->button_text ?? 'Learn More');
        
        return match($format) {
            'tall', 'skyscraper' => $this->generateTallHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor),
            'square' => $this->generateSquareHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor),
            'popup' => $this->generatePopupHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor),
            'native' => $this->generateNativeHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor),
            default => $this->generateWideHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor),
        };
    }

    private function generateWideHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor): string
    {
        $imageHtml = $this->image_url ? "<img src=\"{$this->image_url}\" alt=\"\" style=\"width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 16px;\">" : '';
        
        return <<<HTML
<div style="background-color: {$bgColor}; border: 1px solid {$borderColor}; border-radius: 12px; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; display: flex; align-items: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" onclick="window.open('{$url}', '_blank')">
    {$imageHtml}
    <div style="flex: 1; min-width: 0;">
        <h3 style="color: {$titleColor}; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{$title}</h3>
        <p style="color: {$textColor}; font-size: 14px; line-height: 1.4; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{$description}</p>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px;">
            <span style="color: {$textColor}; font-size: 11px; opacity: 0.6;">Ad · {$domain}</span>
            <button style="background-color: {$buttonColor}; color: white; padding: 8px 20px; border-radius: 6px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; white-space: nowrap;">{$buttonText}</button>
        </div>
    </div>
</div>
HTML;
    }

    private function generateTallHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor): string
    {
        $imageHtml = $this->image_url ? "<img src=\"{$this->image_url}\" alt=\"\" style=\"width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;\">" : '';
        
        return <<<HTML
<div style="background-color: {$bgColor}; border: 1px solid {$borderColor}; border-radius: 12px; padding: 16px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 200px;" onclick="window.open('{$url}', '_blank')">
    {$imageHtml}
    <h3 style="color: {$titleColor}; font-size: 15px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">{$title}</h3>
    <p style="color: {$textColor}; font-size: 12px; line-height: 1.4; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">{$description}</p>
    <button style="background-color: {$buttonColor}; color: white; padding: 10px 16px; border-radius: 6px; border: none; font-weight: 600; font-size: 12px; cursor: pointer; width: 100%;">{$buttonText}</button>
    <span style="display: block; color: {$textColor}; font-size: 10px; opacity: 0.5; margin-top: 8px; text-align: center;">Ad · {$domain}</span>
</div>
HTML;
    }

    private function generateSquareHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor): string
    {
        $imageHtml = $this->image_url ? "<img src=\"{$this->image_url}\" alt=\"\" style=\"width: 100%; height: 100px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;\">" : '';
        
        return <<<HTML
<div style="background-color: {$bgColor}; border: 1px solid {$borderColor}; border-radius: 12px; padding: 18px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08); aspect-ratio: 1; display: flex; flex-direction: column; justify-content: space-between; max-width: 300px;" onclick="window.open('{$url}', '_blank')">
    <div>
        {$imageHtml}
        <h3 style="color: {$titleColor}; font-size: 16px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">{$title}</h3>
        <p style="color: {$textColor}; font-size: 13px; line-height: 1.4; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{$description}</p>
    </div>
    <div>
        <button style="background-color: {$buttonColor}; color: white; padding: 10px 20px; border-radius: 6px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; width: 100%; margin-top: 12px;">{$buttonText}</button>
        <span style="display: block; color: {$textColor}; font-size: 10px; opacity: 0.5; margin-top: 8px; text-align: center;">Ad · {$domain}</span>
    </div>
</div>
HTML;
    }

    private function generatePopupHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor): string
    {
        $imageHtml = $this->image_url ? "<img src=\"{$this->image_url}\" alt=\"\" style=\"width: 100%; height: 140px; object-fit: cover; border-radius: 8px 8px 0 0; margin: -20px -20px 16px -20px; width: calc(100% + 40px);\">" : '';
        
        return <<<HTML
<div style="background-color: {$bgColor}; border: 1px solid {$borderColor}; border-radius: 16px; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; box-shadow: 0 8px 32px rgba(0,0,0,0.15); max-width: 350px; position: relative;">
    <button onclick="this.parentElement.style.display='none'" style="position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 14px; line-height: 1;">×</button>
    {$imageHtml}
    <h3 style="color: {$titleColor}; font-size: 20px; font-weight: 700; margin: 0 0 10px 0; text-align: center;">{$title}</h3>
    <p style="color: {$textColor}; font-size: 14px; line-height: 1.5; margin: 0 0 16px 0; text-align: center;">{$description}</p>
    <button onclick="window.open('{$url}', '_blank')" style="background-color: {$buttonColor}; color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; font-size: 14px; cursor: pointer; width: 100%;">{$buttonText}</button>
    <span style="display: block; color: {$textColor}; font-size: 10px; opacity: 0.5; margin-top: 10px; text-align: center;">Ad · {$domain}</span>
</div>
HTML;
    }

    private function generateNativeHtml($url, $domain, $title, $description, $buttonText, $bgColor, $titleColor, $textColor, $buttonColor, $borderColor): string
    {
        return <<<HTML
<a href="{$url}" target="_blank" style="display: block; text-decoration: none; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 12px 0; border-bottom: 1px solid {$borderColor};">
    <h4 style="color: {$titleColor}; font-size: 15px; font-weight: 600; margin: 0 0 4px 0;">{$title}</h4>
    <p style="color: {$textColor}; font-size: 13px; line-height: 1.4; margin: 0 0 6px 0;">{$description}</p>
    <span style="color: {$buttonColor}; font-size: 12px; font-weight: 500;">{$buttonText} →</span>
    <span style="color: {$textColor}; font-size: 10px; opacity: 0.5; margin-left: 8px;">Ad</span>
</a>
HTML;
    }
}
