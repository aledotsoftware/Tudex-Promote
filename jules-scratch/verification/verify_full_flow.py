from playwright.sync_api import sync_playwright
import time

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # --- Publisher Flow ---
    publisher_email = f"publisher_{int(time.time())}@example.com"
    page.goto("http://127.0.0.1:8000/register")
    page.get_by_label("Name").fill("Test Publisher")
    page.get_by_label("Email").fill(publisher_email)
    page.get_by_label("Register as").select_option("publisher")
    page.get_by_label("Password").nth(0).fill("password")
    page.get_by_label("Confirm Password").fill("password")
    page.get_by_role("button", name="Register").click()

    page.wait_for_url("http://127.0.0.1:8000/sites")
    page.screenshot(path="jules-scratch/verification/publisher_nav.png")

    page.get_by_label("Domain").fill("example-site.com")
    page.get_by_role("button", name="Add Site").click()

    page.wait_for_url("http://127.0.0.1:8000/sites")
    page.screenshot(path="jules-scratch/verification/site_verification_instructions.png")

    # --- Advertiser Flow ---
    page.get_by_role("button", name="Test Publisher").click()
    page.get_by_role("link", name="Log Out").click()

    advertiser_email = f"advertiser_{int(time.time())}@example.com"
    page.goto("http://127.0.0.1:8000/register")
    page.get_by_label("Name").fill("Test Advertiser")
    page.get_by_label("Email").fill(advertiser_email)
    page.get_by_label("Register as").select_option("advertiser")
    page.get_by_label("Password").nth(0).fill("password")
    page.get_by_label("Confirm Password").fill("password")
    page.get_by_role("button", name="Register").click()

    page.wait_for_url("http://127.0.0.1:8000/campaigns")
    page.screenshot(path="jules-scratch/verification/advertiser_nav.png")

    page.get_by_role("link", name="Add Campaign").click()
    page.wait_for_url("http://127.0.0.1:8000/campaigns/create")
    page.get_by_label("Campaign Name").fill("My First Campaign")
    page.get_by_label("Budget").fill("100")
    page.get_by_role("button", name="Create Campaign").click()

    page.wait_for_url("http://127.0.0.1:8000/campaigns")
    page.get_by_role("link", name="My First Campaign").click()

    page.wait_for_url("http://127.0.0.1:8000/campaigns/1")
    page.get_by_role("link", name="Add Creative").click()

    page.wait_for_url("http://127.0.0.1:8000/creatives/create?campaign_id=1")
    page.screenshot(path="jules-scratch/verification/creative_form_prefilled.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
