from playwright.sync_api import sync_playwright
import subprocess

def run(playwright):
    # Seed the database
    subprocess.run(['php', 'artisan', 'migrate:fresh', '--seed'])

    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # Login
    page.goto("http://127.0.0.1:8000/login")
    page.fill('input[name="email"]', "publisher@example.com")
    page.fill('input[name="password"]', "password")
    page.click('button[type="submit"]')
    page.wait_for_url("http://127.0.0.1:8000/dashboard", timeout=60000)

    # Create a new site
    page.goto("http://127.0.0.1:8000/sites")
    page.fill('input[name="domain"]', "example.com")
    page.click('button[type="submit"]')
    page.wait_for_selector("text=example.com")

    # Verify the site (we can't actually verify it, but we can click the button)
    page.click('a[href*="verify"]')
    page.wait_for_selector("text=Verified until")

    # Take a screenshot
    page.screenshot(path="jules-scratch/verification/sites_page.png")

    # Logout and login as advertiser
    page.click('button[aria-label="Account management"]')
    page.click('a[href*="logout"]')
    page.wait_for_url("http://127.0.0.1:8000/login")

    page.fill('input[name="email"]', "advertiser@example.com")
    page.fill('input[name="password"]', "password")
    page.click('button[type="submit"]')
    page.wait_for_url("http://127.0.0.1:8000/dashboard", timeout=60000)

    # Create a new campaign
    page.goto("http://127.0.0.1:8000/campaigns/create")
    page.fill('input[name="name"]', "Test Campaign")
    page.fill('input[name="budget"]', "100")
    page.select_option('select[name="model"]', "cpc")
    page.click('button[type="submit"]')
    page.wait_for_selector("text=Test Campaign")

    # Create a new creative
    page.goto("http://127.0.0.1:8000/creatives/create")
    page.select_option('select[name="campaign_id"]', label="Test Campaign")
    page.fill('input[name="title"]', "Test Creative")
    page.fill('textarea[name="description"]', "This is a test creative.")
    page.fill('input[name="click_url"]', "http://example.com")
    page.fill('input[name="width"]', "300")
    page.fill('input[name="height"]', "250")
    page.click('button[type="submit"]')
    page.wait_for_selector("text=Test Creative")


    # Take a screenshot
    page.screenshot(path="jules-scratch/verification/creatives_page.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
