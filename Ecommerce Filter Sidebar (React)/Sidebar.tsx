'use client'
import { Box } from "../Ui";
import { Input, Checkbox, Rate, Radio, Slider } from 'antd';

export default function ContactUsComponent(){
    return (
       <>
       

            <div 
      style={{
        maxWidth: '600px', 
        height: '100vh', 
        backgroundColor: '#f0f2f5', // Ant Design's default gray background
        padding: '16px'
      }}
    >
      {/* Min */}
      <div style={{ marginBottom: '16px' }}>
        <label 
          htmlFor="min" 
          style={{ display: 'block', fontWeight: 'bold', marginBottom: '8px' }}
        >
          Min
        </label>
        <Input id="min" placeholder="Min" />
      </div>

      {/* Max */}
      <div style={{ marginBottom: '16px' }}>
        <label 
          htmlFor="max" 
          style={{ display: 'block', fontWeight: 'bold', marginBottom: '8px' }}
        >
          Max
        </label>
        <Input id="max" placeholder="Max" />
      </div>

      {/* Categories */}
      <div style={{ marginBottom: '16px' }}>
        <span 
          style={{ display: 'block', fontWeight: 'bold', marginBottom: '8px' }}
        >
          Categories:
        </span>
        <div style={{ marginBottom: '8px' }}>
          <Checkbox>Option 1</Checkbox>
        </div>
        <div>
          <Checkbox>Option 2</Checkbox>
        </div>
      </div>

      {/* Rating */}
      <div style={{ marginBottom: '16px' }}>
        <span 
          style={{ display: 'block', fontWeight: 'bold', marginBottom: '8px' }}
        >
          Rating:
        </span>
        {/* Default value is 3 stars out of 5 */}
        <Rate defaultValue={3} />
      </div>

      {/* Size (Slider) */}
      <div style={{ marginBottom: '16px' }}>
        <span 
          style={{ display: 'block', fontWeight: 'bold', marginBottom: '8px' }}
        >
          Size:
        </span>
        <Slider
          min={1}
          max={5}
          defaultValue={3}
          step={null}
          marks={{
            1: 'XS',
            2: 'SM',
            3: 'MD',
            4: 'LG',
            5: 'XL',
          }}
        />
      </div>
    </div>
        </Container>
       </>
    )
}