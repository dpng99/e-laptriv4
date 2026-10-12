import os
import time
import subprocess
import glob
from playwright.sync_api import sync_playwright

VIDEOS_DIR = os.path.abspath("docs/videos")
os.makedirs(VIDEOS_DIR, exist_ok=True)

CHROME_PATH = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
BASE_URL = "http://127.0.0.1:8000"

def smooth_scroll(page, distance, steps=10, delay=0.05):
    step_dist = distance / steps
    for _ in range(steps):
        page.evaluate(f"window.scrollBy(0, {step_dist})")
        time.sleep(delay)

def record_operator(p):
    print("Mulai merekam: Video Tutorial 1 (Alur Operator Satker)...")
    browser = p.chromium.launch(
        executable_path=CHROME_PATH,
        headless=True,
        args=["--no-sandbox", "--disable-gpu", "--window-size=1280,720"]
    )
    context = browser.new_context(
        record_video_dir=VIDEOS_DIR,
        record_video_size={"width": 1280, "height": 720},
        viewport={"width": 1280, "height": 720}
    )
    page = context.new_page()

    # 1. Login Page
    page.goto(f"{BASE_URL}/login")
    time.sleep(2)
    page.type("input[name='username']", "ro.ren", delay=100)
    time.sleep(0.5)
    page.type("input[name='password']", "password", delay=100)
    time.sleep(1)
    page.click("button[type='submit']")
    page.wait_for_load_state("networkidle")
    time.sleep(2)

    # 2. Operator Dashboard
    smooth_scroll(page, 300, steps=8, delay=0.1)
    time.sleep(2)
    smooth_scroll(page, -300, steps=8, delay=0.1)
    time.sleep(1)

    # 3. Input Data
    page.goto(f"{BASE_URL}/input-data")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    smooth_scroll(page, 250, steps=8, delay=0.1)
    time.sleep(2)

    # Try to type into first available input fields
    inputs = page.query_selector_all("input[type='text'], input[type='number']")
    for inp in inputs[:2]:
        try:
            inp.click()
            time.sleep(0.5)
        except Exception:
            pass

    time.sleep(1)
    smooth_scroll(page, 300, steps=8, delay=0.1)
    time.sleep(2)

    # 4. Profile Page
    page.goto(f"{BASE_URL}/profile")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    smooth_scroll(page, 200, steps=6, delay=0.1)
    time.sleep(1.5)

    # Logout
    page.goto(f"{BASE_URL}/login")
    time.sleep(1)

    page.close()
    context.close()
    browser.close()
    print("Selesai merekam video Operator.")

def record_admin(p):
    print("Mulai merekam: Video Tutorial 2 (Alur Verifikator & Admin JAMBIN)...")
    browser = p.chromium.launch(
        executable_path=CHROME_PATH,
        headless=True,
        args=["--no-sandbox", "--disable-gpu", "--window-size=1280,720"]
    )
    context = browser.new_context(
        record_video_dir=VIDEOS_DIR,
        record_video_size={"width": 1280, "height": 720},
        viewport={"width": 1280, "height": 720}
    )
    page = context.new_page()

    # 1. Login Admin
    page.goto(f"{BASE_URL}/login")
    time.sleep(2)
    page.type("input[name='username']", "admin.jambin", delay=100)
    time.sleep(0.5)
    page.type("input[name='password']", "password", delay=100)
    time.sleep(1)
    page.click("button[type='submit']")
    page.wait_for_load_state("networkidle")
    time.sleep(2)

    # 2. Admin Dashboard
    smooth_scroll(page, 300, steps=8, delay=0.1)
    time.sleep(2)

    # 3. Review Data
    page.goto(f"{BASE_URL}/review-data")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    smooth_scroll(page, 200, steps=6, delay=0.1)
    time.sleep(2)

    # Review Detail
    page.goto(f"{BASE_URL}/review-data/1")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    smooth_scroll(page, 200, steps=6, delay=0.1)
    time.sleep(2)

    # 4. Admin Rumus
    page.goto(f"{BASE_URL}/admin/rumus")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    page.goto(f"{BASE_URL}/admin/rumus/1/edit")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    smooth_scroll(page, 250, steps=6, delay=0.1)
    time.sleep(2)

    # 5. Admin Template
    page.goto(f"{BASE_URL}/admin/template")
    page.wait_for_load_state("networkidle")
    time.sleep(2)

    # 6. Export LKjIP
    page.goto(f"{BASE_URL}/export")
    page.wait_for_load_state("networkidle")
    time.sleep(2)
    smooth_scroll(page, 150, steps=5, delay=0.1)
    time.sleep(2)

    page.close()
    context.close()
    browser.close()
    print("Selesai merekam video Admin.")

def convert_and_label_videos():
    print("Mengonversi berkas rekaman video menjadi format MP4 standar...")
    webm_files = sorted(glob.glob(os.path.join(VIDEOS_DIR, "*.webm")), key=os.path.getmtime)
    print(f"Ditemukan {len(webm_files)} berkas webm mentah.")
    
    target_names = [
        "Video_1_Tutorial_Operator_Input_Kinerja.mp4",
        "Video_2_Tutorial_Admin_Verifikasi_Rumus_Ekspor.mp4"
    ]

    for idx, webm in enumerate(webm_files[-2:]):
        target_name = target_names[idx] if idx < len(target_names) else f"Video_Tutorial_{idx+1}.mp4"
        out_mp4 = os.path.join(VIDEOS_DIR, target_name)
        cmd = [
            "ffmpeg", "-y", "-i", webm,
            "-c:v", "libx264", "-pix_fmt", "yuv420p", "-crf", "22", "-preset", "fast",
            out_mp4
        ]
        res = subprocess.run(cmd, capture_output=True, text=True)
        if res.returncode == 0:
            print(f"Berhasil dibuat: {out_mp4} ({os.path.getsize(out_mp4)} bytes)")
            # Generate thumbnail/preview frame
            thumb_name = target_name.replace(".mp4", "_thumb.png")
            thumb_path = os.path.join(VIDEOS_DIR, thumb_name)
            cmd_thumb = [
                "ffmpeg", "-y", "-ss", "00:00:05", "-i", out_mp4,
                "-vframes", "1", "-q:v", "2", thumb_path
            ]
            subprocess.run(cmd_thumb, capture_output=True)
            print(f"Thumbnail dibuat: {thumb_path}")
        else:
            print(f"Gagal konversi {webm}:", res.stderr)

    # Master Concatenated Video: Video_Tutorial_Keseluruhan_ELAPTRI.mp4
    v1 = os.path.join(VIDEOS_DIR, "Video_1_Tutorial_Operator_Input_Kinerja.mp4")
    v2 = os.path.join(VIDEOS_DIR, "Video_2_Tutorial_Admin_Verifikasi_Rumus_Ekspor.mp4")
    master_mp4 = os.path.join(VIDEOS_DIR, "Video_Tutorial_Keseluruhan_ELAPTRI.mp4")
    
    if os.path.exists(v1) and os.path.exists(v2):
        concat_list = os.path.join(VIDEOS_DIR, "concat_list.txt")
        with open(concat_list, "w", encoding="utf-8") as f:
            f.write(f"file '{v1}'\nfile '{v2}'\n")
        cmd_concat = [
            "ffmpeg", "-y", "-f", "concat", "-safe", "0", "-i", concat_list,
            "-c", "copy", master_mp4
        ]
        res_cat = subprocess.run(cmd_concat, capture_output=True, text=True)
        if res_cat.returncode == 0:
            print(f"Master Video Keseluruhan berhasil digabung: {master_mp4} ({os.path.getsize(master_mp4)} bytes)")
            master_thumb = os.path.join(VIDEOS_DIR, "Video_Tutorial_Keseluruhan_thumb.png")
            cmd_mthumb = [
                "ffmpeg", "-y", "-ss", "00:00:08", "-i", master_mp4,
                "-vframes", "1", "-q:v", "2", master_mthumb
            ]
            subprocess.run(cmd_mthumb, capture_output=True)
        if os.path.exists(concat_list):
            os.remove(concat_list)

def main():
    with sync_playwright() as p:
        record_operator(p)
        record_admin(p)
    convert_and_label_videos()

if __name__ == "__main__":
    main()
