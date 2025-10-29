from playwright.sync_api import sync_playwright, expect
import subprocess

def run(playwright):
    # 1. Arrange: Seed the database for a clean state
    try:
        subprocess.run(['php', 'artisan', 'migrate:fresh', '--seed'], check=True, capture_output=True, text=True)
    except subprocess.CalledProcessError as e:
        print("Error seeding database:")
        print(e.stderr)
        raise

    browser = playwright.chromium.launch(headless=True)
    page = browser.new_page()

    # --- Test Case 1: Publisher Flow ---

    # 2. Act: Log in as publisher
    page.goto("http://127.0.0.1:8000/login")
    page.fill('input[name="email"]', "publisher@example.com")
    page.fill('input[name="password"]', "password")
    page.get_by_role("button", name="Log in").click()
    expect(page).to_have_url("http://127.0.0.1:8000/sites")

    # 3. Act: Create a new site
    page.goto("http://127.0.0.1:8000/sites")
    page.fill('input[name="domain"]', "verified-site.com")
    page.get_by_role("button", name="Add Site").click()
    expect(page.locator('.font-semibold:text("verified-site.com")')).to_be_visible()

    # 4. Act: "Verify" the site by clicking the button
    page.get_by_role("link", name="Verify Now").click()

    # 5. Assert: Check for the correct redirection by looking for the test ID on the sites.show page
    expect(page.get_by_test_id("add-ad-zone-heading")).to_be_visible()
    expect(page).to_have_url(lambda url: '/sites/' in url) # Check that we are on the details page

    # 6. Act: Go back to the sites list
    page.goto("http://127.0.0.1:8000/sites")

    # 7. Assert: Check that the "Manage Ad Zones" link is now visible
    manage_link = page.get_by_role("link", name="Manage Ad Zones / Get Code")
    expect(manage_link).to_be_visible()

    # 8. Screenshot: Capture the state of the sites index page
    page.screenshot(path="jules-scratch/verification/publisher_flow.png")

    # --- Test Case 2: Advertiser Flow ---

    # 9. Act: Log out and log in as advertiser
    page.get_by_role("button", name="Account management").click()
    page.get_by_role("menuitem", name="Log Out").click()
    expect(page).to_have_url("http://127.0.0.1:8000/login")

    page.fill('input[name="email"]', "advertiser@example.com")
    page.fill('input[name="password"]', "password")
    page.get_by_role("button", name="Log in").click()
    expect(page).to_have_url("http://127.0.0.1:8000/dashboard")

    # 10. Act: Create a campaign and a creative to ensure one exists
    page.goto("http://127.0.0.1:8000/campaigns/create")
    page.fill('input[name="name"]', "Test Campaign")
    page.fill('input[name="budget"]', "100")
    page.get_by_role("button", name="Create Campaign").click()
    expect(page.get_by_text("Campaign created successfully")).to_be_visible()

    page.goto("http://127.0.0.1:8000/creatives/create")
    page.get_by_label("Campaign").select_option(label="Test Campaign")
    page.fill('input[name="title"]', "My Test Ad")
    page.fill('textarea[name="description"]', "A great ad.")
    page.fill('input[name="click_url"]', "http://example.com")
    page.fill('input[name="width"]', "300")
    page.fill('input[name="height"]', "250")
    page.get_by_role("button", name="Create Creative").click()
    expect(page.get_by_text("Creative added successfully")).to_be_visible()


    # 11. Act: Navigate to the creatives index and click the first "View" link
    page.goto("http://127.0.0.1:8000/creatives")
    page.get_by_role("link", name="View").first.click()

    # 12. Assert: Check that the creative details page loads without error
    expect(page.get_by_role("heading", name="Creative Details")).to_be_visible()
    expect(page.get_by_text("Preview")).to_be_visible()

    # 13. Screenshot: Capture the creative details page
    page.screenshot(path="jules-scratch/verification/advertiser_flow.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
