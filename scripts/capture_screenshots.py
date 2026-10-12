import os
import time
from playwright.sync_api import sync_playwright

OUTPUT_DIR = os.path.abspath("docs/manual_assets")
os.makedirs(OUTPUT_DIR, exist_ok=True)

CHROME_PATH = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
BASE_URL = "http://127.0.0.1:8000"

def run():
    print(f"Connecting to {BASE_URL} using Chrome at {CHROME_PATH}...")
    with sync_playwright() as p:
        browser = p.chromium.launch(
            executable_path=CHROME_PATH,
            headless=True,
            args=["--no-sandbox", "--disable-gpu", "--window-size=1440,1050"]
        )
        context = browser.new_context(viewport={"width": 1440, "height": 1050})
        page = context.new_page()

        # 1. Login Page
        print("Capturing 01_login_page.png...")
        page.goto(f"{BASE_URL}/login")
        page.wait_for_selector("input[name='username']", timeout=10000)
        time.sleep(1)
        page.screenshot(path=os.path.join(OUTPUT_DIR, "01_login_page.png"))

        # 2. Operator Login (ro.ren)
        print("Logging in as ro.ren (Operator Biro Perencanaan)...")
        page.fill("input[name='username']", "ro.ren")
        page.fill("input[name='password']", "password")
        page.click("button[type='submit']")
        page.wait_for_load_state("networkidle")
        time.sleep(2)

        # 3. Operator Dashboard
        print("Capturing 02_operator_dashboard.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "02_operator_dashboard.png"))

        # 4. Operator Dashboard Scrolled (Charts)
        print("Scrolling dashboard to capture charts...")
        page.evaluate("window.scrollBy(0, 450)")
        time.sleep(1)
        page.screenshot(path=os.path.join(OUTPUT_DIR, "02b_operator_dashboard_charts.png"))

        # 5. Input Data - Sasaran Kegiatan / Program
        print("Navigating to /input-data...")
        page.goto(f"{BASE_URL}/input-data")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 03_input_data_sp.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "03_input_data_sp.png"))

        # Scroll into IKK / IKP card details
        print("Scrolling into formula inputs in input-data...")
        page.evaluate("window.scrollBy(0, 500)")
        time.sleep(1)
        page.screenshot(path=os.path.join(OUTPUT_DIR, "04_input_data_details.png"))

        page.evaluate("window.scrollBy(0, 600)")
        time.sleep(1)
        page.screenshot(path=os.path.join(OUTPUT_DIR, "04b_input_data_analysis.png"))

        # 6. Profile Page
        print("Navigating to /profile...")
        page.goto(f"{BASE_URL}/profile")
        page.wait_for_load_state("networkidle")
        time.sleep(1)
        print("Capturing 06_profile_page.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "06_profile_page.png"))

        # Logout operator
        print("Logging out operator...")
        page.goto(f"{BASE_URL}/login")
        context.clear_cookies()

        # Login as Admin (admin.jambin)
        print("Logging in as admin.jambin (Super Admin JAMBIN)...")
        page.goto(f"{BASE_URL}/login")
        page.wait_for_selector("input[name='username']", timeout=10000)
        page.fill("input[name='username']", "admin.jambin")
        page.fill("input[name='password']", "password")
        page.click("button[type='submit']")
        page.wait_for_load_state("networkidle")
        time.sleep(2)

        # 7. Admin Dashboard
        print("Capturing 07_admin_dashboard.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "07_admin_dashboard.png"))

        # 8. Review Data Index
        print("Navigating to /review-data...")
        page.goto(f"{BASE_URL}/review-data")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 08_review_data_index.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "08_review_data_index.png"))

        # 9. Review Data Detail
        print("Navigating to /review-data/1...")
        page.goto(f"{BASE_URL}/review-data/1")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 09_review_data_detail.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "09_review_data_detail.png"))

        # 10. Admin Rumus
        print("Navigating to /admin/rumus...")
        page.goto(f"{BASE_URL}/admin/rumus")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 10_admin_rumus_index.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "10_admin_rumus_index.png"))

        # 11. Admin Rumus Edit
        print("Navigating to /admin/rumus/1/edit...")
        page.goto(f"{BASE_URL}/admin/rumus/1/edit")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 10b_admin_rumus_edit.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "10b_admin_rumus_edit.png"))

        # 12. Admin Template
        print("Navigating to /admin/template...")
        page.goto(f"{BASE_URL}/admin/template")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 11_admin_template_index.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "11_admin_template_index.png"))

        # 13. Export LKjIP
        print("Navigating to /export...")
        page.goto(f"{BASE_URL}/export")
        page.wait_for_load_state("networkidle")
        time.sleep(2)
        print("Capturing 12_export_index.png...")
        page.screenshot(path=os.path.join(OUTPUT_DIR, "12_export_index.png"))

        browser.close()
        print("All detailed screenshots successfully captured!")

if __name__ == "__main__":
    run()
