<template>
   <!-- Loader Section -->
   <div id="answer-loader">
                <div class="flex justify-center items-center">
                  <div>
                    <svg class="w-60 h-60" width="240" height="240" viewBox="0 0 240 240">
                      <circle class="text-gray-400 animate-circle" cx="120" cy="120" r="105" fill="none" stroke="blue"
                        stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round">
                      </circle>
                      <circle class="text-gray-400 animate-circle" cx="120" cy="120" r="35" fill="none" stroke="indigo"
                        stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round">
                      </circle>
                      <circle class="text-gray-400 animate-circle" cx="85" cy="120" r="70" fill="none" stroke="blue"
                        stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                      <circle class="text-gray-400 animate-circle" cx="155" cy="120" r="70" fill="none" stroke="indigo"
                        stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                    </svg>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <h6 class="text-gray-600">One moment while I get the answer...</h6>
                  <div id="answer-loader-text" class="text-gray-500">
                    Did you know that the average human attention span is 8 seconds?
                  </div>
                </div>
              </div>
</template>

<style scoped>

/* Define the highlight animation for circles */
@keyframes highlight {
  0% {
    stroke-dashoffset: 0;
    stroke-width: 20;
  }
  50% {
    stroke-dashoffset: 0;
    stroke-width: 10;
  }
  100% {
    stroke-dashoffset: 0;
    stroke-width: 20;
  }
}

@keyframes fadeInOut {
  0%, 100% {
    opacity: 0.5;
  }
  50% {
    opacity: 1;
  }
}

/* Apply animation to circles */
.animate-circle {
  animation: highlight 1s ease-in-out infinite, fadeInOut 0.8s ease-in-out infinite;
}

/* Delay the animation for each circle for sequential effect */
svg circle:nth-child(1) {
  animation-delay: 0.2s;
}
svg circle:nth-child(2) {
  animation-delay: 0.4s;
}
svg circle:nth-child(3) {
  animation-delay: 0.6s;
}
svg circle:nth-child(4) {
  animation-delay: 0.8s;
}

</style>
