import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/welcome');
  await page.getByRole('link', { name: 'Beranda' }).click();
  await page.getByRole('link', { name: 'UMKM', exact: true }).click();
  await page.locator('section').click();
  await page.getByRole('link', { name: '← Kembali ke Beranda' }).click();
  await page.getByRole('link', { name: 'Artikel' }).click();
  await page.getByRole('link', { name: '← Kembali ke Beranda' }).click();
  await page.getByRole('main').click();
});