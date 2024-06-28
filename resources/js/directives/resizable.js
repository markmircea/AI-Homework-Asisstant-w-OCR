// resources/js/directives/resizable.js

export default {
    mounted(el) {
      const resizeHandle = document.createElement('div');
      resizeHandle.style.width = '10px';
      resizeHandle.style.height = '100%';
      resizeHandle.style.position = 'absolute';
      resizeHandle.style.right = '0';
      resizeHandle.style.top = '0';
      resizeHandle.style.cursor = 'col-resize';
      resizeHandle.style.userSelect = 'none';

       // Make the handle visible
    resizeHandle.style.backgroundColor = 'rgba(0, 0, 0, 0.1)';


      el.style.position = 'relative';
      el.appendChild(resizeHandle);

      const onMouseMove = (e) => {
        const dx = e.movementX;
        el.style.width = `${el.offsetWidth + dx}px`;
      };

      const onMouseUp = () => {
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
      };

      resizeHandle.addEventListener('mousedown', () => {
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
      });
    }
  };
