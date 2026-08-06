import type { ClassValue } from "clsx"
import { clsx } from "clsx"
import { twMerge } from "tailwind-merge"
import type { InertiaLinkProps } from '@inertiajs/vue3';

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export function toUrl(
  href: NonNullable<InertiaLinkProps['href']>,
): string {
  if (typeof href === 'string') {
    return href;
  }

  if (href instanceof URL) {
    return href.toString();
  }

  return href.url;
}