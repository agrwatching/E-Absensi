<style>
    @keyframes rainbow {
      0% { color: #ff0000; }
      20% { color: #ff9900; }
      40% { color: #ffff00; }
      60% { color: #00ff00; }
      80% { color: #0000ff; }
      100% { color: #ff00ff; }
    }

    .rainbow-animate {
      animation: rainbow 2s infinite linear;
    }
  </style>
<footer class="bg-stone-900 py-4 shadow-inner grid grid-cols-2 items-center">
    <h2 class="text-center text-sm text-stone-600 pl-4"><a href="https://smpisr.id/"><span class="font-extrabold rainbow-animate drop-shadow-lg tracking-wide">
    SMP IGNIATUS SLAMET RIYADI
  </span></a>
        © <?= date('Y'); ?> by <a href="https://portfolio-website-black-eight-59.vercel.app/" class="underline">Watching</a>
    </h2>
    <h2 class="text-center text-sm text-gray-400 pr-4">
        Version 2.3.8
    </h2>
</footer>
