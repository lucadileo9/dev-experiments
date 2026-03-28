<footer {{ $attributes->merge(['class' => 'footer footer-center p-10 bg-base-200 text-base-content rounded mt-8']) }}>
  <nav class="grid grid-flow-col gap-4">
    <a href="/" class="link link-hover">Home</a>
    <a href="/about" class="link link-hover">About us</a>
    <a href="/contact" class="link link-hover">Contact</a>
  </nav>
  <aside>
    <p>Copyright © {{ date('Y') }} - All rights reserved by My Website</p>
  </aside>
</footer>
